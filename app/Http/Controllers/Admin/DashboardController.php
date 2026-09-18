<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\AccountRole;
use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\AuditEvent;
use App\Models\Board;
use App\Models\Card;
use App\Models\FinancialTransaction;
use App\Models\Leads;
use App\Models\MailOutbox;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user() ?? abort(401);
        $role = $user->role();
        $metrics = [];
        $records = collect();
        if ($role === AccountRole::Finance) {
            $income = FinancialTransaction::where('type', 'income')->where('status', 'paid')->sum('amount');
            $expense = FinancialTransaction::where('type', 'expense')->where('status', 'paid')->sum('amount');
            $metrics = ['Recebimentos' => $this->money($income), 'Despesas pagas' => $this->money($expense), 'Saldo realizado' => $this->money($income - $expense), 'Vencidos' => FinancialTransaction::where('status', 'pending')->whereDate('due_date', '<', today())->count()];
            $records = FinancialTransaction::latest()->limit(8)->get()->map(fn ($t): array => ['title' => $t->description, 'detail' => $this->money($t->amount).' · '.$t->status]);
        } elseif ($role === AccountRole::Technical) {
            $metrics = ['Usuários ativos' => User::where('access_active', true)->count(), 'Acessos pendentes' => AccessRequest::where('status', 'pending')->count(), 'E-mails pendentes' => MailOutbox::where('status', 'pending')->count(), 'Falhas de envio' => MailOutbox::where('status', 'failed')->count()];
            $records = AuditEvent::latest()->limit(10)->get()->map(fn ($a): array => ['title' => $a->action, 'detail' => $a->created_at?->timezone($user->preferences['timezone'] ?? 'America/Manaus')->format('d/m/Y H:i')]);
        } else {
            $boards = Board::visibleTo($user);
            $cards = Card::whereIn('project_id', (clone $boards)->select('id'));
            if ($role === AccountRole::Developer) {
                $cards->where('assigned_to', $user->id);
            }
            $metrics = ['Projetos acessíveis' => (clone $boards)->count(), $role === AccountRole::Developer ? 'Minhas tarefas' : 'Tarefas' => (clone $cards)->count(), 'Prazo vencido' => (clone $cards)->whereDate('due_date', '<', today())->whereNull('completed_at')->count(), 'Concluídas' => (clone $cards)->whereNotNull('completed_at')->count()];
            if ($role === AccountRole::Owner) {
                $metrics['Leads recebidos'] = Leads::count();
            }
            if ($role === AccountRole::Manager) {
                $metrics['Leads recebidos'] = Leads::count();
                $metrics['Solicitações pendentes'] = AccessRequest::where('status', 'pending')->count();
                $metrics['Recebimentos'] = $this->money(FinancialTransaction::where('type', 'income')->where('status', 'paid')->sum('amount'));
            }
            $records = $cards->with('assignee')->latest('updated_at')->limit(8)->get()->map(fn ($c): array => ['title' => $c->title, 'detail' => ($c->assignee->name ?? 'Sem responsável').' · '.($c->due_date?->format('d/m/Y') ?? 'Sem prazo')]);
        }

        return view('pages.admin.dashboard', ['metrics' => $metrics, 'records' => $records, 'role' => $role]);
    }

    private function money(int|float|string $value): string
    {
        return 'R$ '.number_format((float) $value, 2, ',', '.');
    }
}
