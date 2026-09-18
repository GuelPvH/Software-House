<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardFormRequest;
use App\Models\AuditEvent;
use App\Models\Board;
use App\Models\BoardColumn;
use App\Models\Card;
use App\Models\ChecklistItem;
use App\Models\Client;
use App\Models\MailOutbox;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

final class ProjectController extends Controller
{
    public function __invoke(Request $request): View
    {
        $boards = Board::visibleTo($request->user() ?? abort(401))->orderBy('name')->get();
        $board = $request->filled('board') ? $boards->firstWhere('id', (int) $request->query('board')) : $boards->first();
        abort_if($request->filled('board') && ! $board, 403);
        $board?->load(['columns.cards.assignee', 'columns.cards.comments', 'columns.cards.checklist', 'members']);
        $users = User::where('access_active', true)->get()->filter(fn ($u) => $u->canModule('projects'));
        $archived = $board?->cards()->onlyTrashed()->latest('deleted_at')->get() ?? collect();

        return view('pages.admin.projects.index', ['boards' => $boards, 'board' => $board, 'users' => $users, 'archived' => $archived]);
    }

    public function store(BoardFormRequest $request): RedirectResponse
    {
        Gate::authorize('create', Board::class);
        $board = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $board = Board::create(['name' => $data['name'], 'client_id' => Client::firstOrCreate(['name' => $data['client_name']], ['created_by' => $request->user()?->id])->id, 'responsible_id' => $request->user()?->id]);
            $this->members($board, $data['members'] ?? []);
            foreach (['A fazer', 'Em andamento', 'Em revisão', 'Concluído'] as $position => $name) {
                $board->columns()->create(['name' => $name, 'order_index' => $position, 'is_done' => $name === 'Concluído']);
            }

            return $board;
        });

        return to_route('admin.projects.index', ['board' => $board->id])->with('success', 'Quadro criado.');
    }

    public function update(BoardFormRequest $request, Board $board): RedirectResponse
    {
        Gate::authorize('manage', $board);
        DB::transaction(function () use ($request, $board): void {
            $data = $request->validated();
            $board->update(['name' => $data['name'], 'client_id' => Client::firstOrCreate(['name' => $data['client_name']], ['created_by' => $request->user()?->id])->id]);
            $this->members($board, $data['members'] ?? []);
            $board->increment('version');
        });

        return back()->with('success', 'Quadro atualizado.');
    }

    /** @param list<int> $ids */
    private function members(Board $board, array $ids): void
    {
        $eligible = User::whereIn('id', $ids)->where('access_active', true)->get()->filter(fn ($u) => $u->canModule('projects'))->pluck('id')->all();
        abort_if(array_diff(array_map(intval(...), $ids), $eligible) !== [], 422, 'Membro sem acesso ao Kanban.');
        $assigned = $board->cards()->whereNotNull('assigned_to')->pluck('assigned_to')->unique()->all();
        abort_if(array_diff($assigned, $eligible) !== [], 422, 'Reatribua os cartões antes de remover seus responsáveis.');
        $board->members()->sync($eligible);
    }

    public function column(BoardFormRequest $request, Board $board): RedirectResponse
    {
        Gate::authorize('manage', $board);
        DB::transaction(function () use ($request, $board): void {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            $board->columns()->create(['name' => $request->validated('name'), 'order_index' => $board->columns()->count()]);
            $board->increment('version');
        });

        return back()->with('success', 'Lista adicionada.');
    }

    public function storeCard(BoardFormRequest $request, Board $board): RedirectResponse
    {
        Gate::authorize('update', $board);
        DB::transaction(function () use ($request, $board): void {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            $data = $this->cardData($request, $board);
            $data['position'] = $board->cards()->where('stage_id', $data['stage_id'])->count();
            $card = $board->cards()->create($data);
            $board->increment('version');
            $this->audit($request, $card, 'card.created');
        });

        return back()->with('success', 'Cartão criado.');
    }

    public function updateCard(BoardFormRequest $request, Board $board, Card $card): RedirectResponse
    {
        Gate::authorize('update', $board);
        abort_unless($card->project_id === $board->id, 404);
        DB::transaction(function () use ($request, $board, $card): void {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            $card->refresh();
            abort_unless((int) $request->input('version') === $card->version, 409, 'Cartão alterado por outra pessoa. Recarregue antes de salvar.');
            $data = $this->cardData($request, $board);
            if ($card->stage_id !== $data['stage_id']) {
                $data['position'] = $board->cards()->where('stage_id', $data['stage_id'])->count();
            }
            $card->update($data);
            $card->increment('version');
            $board->increment('version');
            $this->audit($request, $card, 'card.updated');
        });

        return back()->with('success', 'Cartão atualizado.');
    }

    /** @return array<string, mixed> */
    private function cardData(BoardFormRequest $request, Board $board): array
    {
        $data = $request->validated();
        $data['stage_id'] = (int) $data['stage_id'];
        abort_unless($board->columns()->whereKey($data['stage_id'])->exists(), 422, 'Lista inválida.');
        abort_if(! empty($data['assigned_to']) && ! $board->members()->where('users.id', $data['assigned_to'])->exists(), 422, 'Responsável deve participar do quadro.');
        $done = $board->columns()->findOrFail($data['stage_id'])->is_done;
        $data['completed_at'] = $done ? now() : null;
        $data['status'] = $done ? 'done' : 'in_progress';
        $data['labels'] = array_values(array_filter(array_map(trim(...), explode(',', $data['labels'] ?? ''))));
        unset($data['version']);

        return $data;
    }

    public function move(BoardFormRequest $request, Board $board): JsonResponse
    {
        Gate::authorize('update', $board);
        $version = DB::transaction(function () use ($request, $board) {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            abort_unless($board->version === (int) $request->input('version'), 409, 'O quadro mudou. Recarregue para continuar.');
            /** @var list<array{id:int, cards:list<int>}> $columns */
            $columns = $request->validated('columns');
            $submittedColumns = array_column($columns, 'id');
            sort($submittedColumns);
            $knownColumns = $board->columns()->pluck('id')->sort()->values()->all();
            abort_unless($submittedColumns === $knownColumns, 422, 'Listas inválidas.');
            $ids = collect($columns)->pluck('cards')->flatten()->all();
            $known = $board->cards()->pluck('id')->sort()->values()->all();
            $sorted = $ids;
            sort($sorted);
            abort_unless($sorted === $known && count($ids) === count(array_unique($ids)), 422, 'Cartões inválidos.');
            foreach ($columns as $column) {
                foreach ($column['cards'] as $position => $id) {
                    $card = $board->cards()->findOrFail($id);
                    if ($card->stage_id !== (int) $column['id'] || $card->position !== $position) {
                        $done = $board->columns()->findOrFail($column['id'])->is_done;
                        $card->update(['stage_id' => $column['id'], 'position' => $position, 'version' => $card->version + 1, 'completed_at' => $done ? ($card->completed_at ?? now()) : null, 'status' => $done ? 'done' : 'in_progress']);
                        $this->audit($request, $card, 'card.moved');
                    }
                }
            }
            $board->increment('version');

            return $board->version;
        });

        return response()->json(['version' => $version]);
    }

    public function archive(Request $request, Board $board, Card $card): RedirectResponse
    {
        Gate::authorize('update', $board);
        abort_unless($card->project_id === $board->id, 404);
        DB::transaction(function () use ($request, $board, $card): void {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            $card->delete();
            $board->increment('version');
            $this->audit($request, $card, 'card.archived');
        });

        return back()->with('success', 'Cartão arquivado.');
    }

    public function comment(BoardFormRequest $request, Board $board, Card $card): RedirectResponse
    {
        Gate::authorize('update', $board);
        abort_unless($card->project_id === $board->id, 404);
        $card->comments()->create(['user_id' => $request->user()?->id, 'content' => $request->validated('body')]);

        return back()->with('success', 'Comentário adicionado.');
    }

    public function checklist(BoardFormRequest $request, Board $board, Card $card): RedirectResponse
    {
        Gate::authorize('update', $board);
        abort_unless($card->project_id === $board->id, 404);
        $card->checklist()->create($request->validated());

        return back()->with('success', 'Item adicionado.');
    }

    public function toggle(BoardFormRequest $request, Board $board, Card $card, ChecklistItem $item): RedirectResponse
    {
        Gate::authorize('update', $board);
        abort_unless($card->project_id === $board->id && $item->task_id === $card->id, 404);
        $item->update($request->validated());

        return back()->with('success', 'Checklist atualizado.');
    }

    public function restore(Request $request, Board $board, int $cardId): RedirectResponse
    {
        Gate::authorize('update', $board);
        DB::transaction(function () use ($request, $board, $cardId): void {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            $card = $board->cards()->onlyTrashed()->findOrFail($cardId);
            $card->restore();
            $card->increment('version');
            $board->increment('version');
            $this->audit($request, $card, 'card.restored');
        });

        return back()->with('success', 'Cartão restaurado.');
    }

    public function updateColumn(BoardFormRequest $request, Board $board, BoardColumn $column): RedirectResponse
    {
        Gate::authorize('manage', $board);
        abort_unless($column->project_id === $board->id, 404);
        DB::transaction(function () use ($request, $board, $column): void {
            $board = Board::lockForUpdate()->findOrFail($board->id);
            $column->update(['name' => $request->validated('name'), 'is_done' => $request->boolean('is_done')]);
            foreach ($column->cards as $card) {
                $card->update(['completed_at' => $column->is_done ? ($card->completed_at ?? now()) : null, 'status' => $column->is_done ? 'done' : 'in_progress', 'version' => $card->version + 1]);
            }
            $board->increment('version');
        });

        return back()->with('success', 'Lista atualizada.');
    }

    private function audit(Request $request, Card $card, string $action): void
    {
        $recipient = $card->assignee;
        if ($recipient && $recipient->id !== $request->user()?->id && $recipient->canModule('projects') && ($recipient->preferences['email_enabled'] ?? true) && ($recipient->preferences['project_alerts'] ?? true)) {
            MailOutbox::enqueue($recipient->email, 'Atualização de tarefa: '.$card->title, 'Uma tarefa atribuída a você foi atualizada. Consulte '.route('admin.projects.index', ['board' => $card->project_id]));
        }
        AuditEvent::create(['user_id' => $request->user()?->id, 'action' => $action, 'entity' => 'card', 'entity_id' => $card->id, 'details' => ['project_id' => $card->project_id, 'stage_id' => $card->stage_id]]);
    }
}
