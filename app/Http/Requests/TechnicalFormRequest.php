<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\AccountRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class TechnicalFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canModule('technical') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return match ($this->route()?->getName()) {
            'admin.technical.user' => ['account_role' => ['required', Rule::enum(AccountRole::class)], 'access_active' => ['required', 'boolean'], 'specialty' => ['nullable', 'string', 'max:160'], 'skills' => ['nullable', 'string', 'max:2000']],
            'admin.technical.routes' => ['route_name' => ['required', 'string', 'max:180'], 'label' => ['required', 'string', 'max:180'], 'roles' => ['required', 'array', 'min:1'], 'roles.*' => [Rule::enum(AccountRole::class)]],
            default => [],
        };
    }
}
