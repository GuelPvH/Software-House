<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Board;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

final class BoardFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! $this->user()?->canModule('projects')) {
            return false;
        }
        $board = $this->route('board');
        if (! $board) {
            return Gate::allows('create', Board::class);
        }
        $ability = in_array($this->route()?->getName(), ['admin.projects.update', 'admin.projects.columns', 'admin.projects.columns.update'], true) ? 'manage' : 'update';

        return Gate::allows($ability, $board);
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return match ($this->route()?->getName()) {
            'admin.projects.store', 'admin.projects.update' => ['name' => ['required', 'string', 'max:160'], 'client_name' => ['required', 'string', 'max:160'], 'members' => ['array'], 'members.*' => ['integer', Rule::exists('users', 'id')->where('access_active', true)]],
            'admin.projects.columns', 'admin.projects.columns.update' => ['name' => ['required', 'string', 'max:100'], 'is_done' => ['sometimes', 'boolean']],
            'admin.projects.cards.store', 'admin.projects.cards.update' => ['title' => ['required', 'string', 'max:200'], 'description' => ['nullable', 'string', 'max:10000'], 'stage_id' => ['required', 'integer'], 'assigned_to' => ['nullable', 'integer'], 'priority' => ['required', Rule::in(['low', 'medium', 'high'])], 'due_date' => ['nullable', 'date'], 'labels' => ['nullable', 'string', 'max:300'], 'version' => ['sometimes', 'integer']],
            'admin.projects.move' => ['version' => ['required', 'integer'], 'columns' => ['required', 'array'], 'columns.*.id' => ['required', 'integer'], 'columns.*.cards' => ['present', 'array'], 'columns.*.cards.*' => ['integer']],
            'admin.projects.comments' => ['body' => ['required', 'string', 'max:4000']],
            'admin.projects.checklist' => ['title' => ['required', 'string', 'max:200']],
            'admin.projects.checklist.toggle' => ['completed' => ['required', 'boolean']],
            default => [],
        };
    }
}
