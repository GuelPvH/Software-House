<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class SettingsFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canModule('settings') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return match ($this->route()?->getName()) {
            'admin.settings.profile.save' => ['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user()?->id)], 'phone' => ['nullable', 'string', 'max:40'], 'timezone' => ['required', 'timezone'], 'theme' => ['required', Rule::in(['light', 'dark'])], 'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], 'remove_photo' => ['sometimes', 'boolean'], 'current_password' => [Rule::requiredIf(fn (): bool => strtolower((string) $this->input('email')) !== $this->user()?->email), 'nullable', 'current_password']],
            'admin.settings.company.save' => ['legal_name' => ['required', 'string', 'max:255'], 'trade_name' => ['required', 'string', 'max:255'], 'document' => ['nullable', 'string', 'max:32'], 'commercial_email' => ['nullable', 'email'], 'postal_code' => ['nullable', 'string', 'max:20'], 'address' => ['nullable', 'string', 'max:255'], 'city' => ['nullable', 'string', 'max:120'], 'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048']],
            'admin.settings.notifications.save' => ['email_enabled' => ['sometimes', 'boolean'], 'project_alerts' => ['sometimes', 'boolean'], 'digest_frequency' => ['required', Rule::in(['off', 'daily', 'weekly', 'monthly'])]],
            'admin.settings.security.save' => ['current_password' => ['required', 'current_password'], 'password' => ['required', 'confirmed', Password::min(12)->letters()->numbers()]],
            'admin.settings.sessions', 'admin.settings.two-factor.disable', 'admin.settings.two-factor.recovery' => ['current_password' => ['required', 'current_password']],
            'admin.settings.two-factor.confirm' => ['code' => ['required', 'digits:6']],
            'admin.settings.token' => ['current_password' => ['required', 'current_password']],
            default => [],
        };
    }
}
