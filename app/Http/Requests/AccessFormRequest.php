<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\AccountRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class AccessFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return match ($this->route()?->getName()) {
            'login.store' => ['email' => ['required', 'email'], 'password' => ['required', 'string']],
            'access.store' => ['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255'], 'termos' => ['accepted']],
            'admin.access.review' => ['decision' => ['required', Rule::in(['approved', 'rejected'])], 'role' => ['required', Rule::enum(AccountRole::class)], 'note' => ['nullable', 'string', 'max:2000']],
            'password.email' => ['email' => ['required', 'email']],
            'password.update' => ['email' => ['required', 'email'], 'token' => ['required', 'string'], 'password' => ['required', 'confirmed', Password::min(12)->letters()->numbers()]],
            'two-factor.verify' => ['code' => ['required', 'string', 'max:100']],
            default => [],
        };
    }
}
