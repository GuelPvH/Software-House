<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class FinanceFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canModule('finance') ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return ['description' => ['required', 'string', 'max:255'], 'type' => ['required', Rule::in(['income', 'expense'])], 'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999999.99', 'decimal:0,2'], 'due_date' => ['required', 'date'], 'status' => ['required', Rule::in(['pending', 'paid', 'cancelled'])], 'counterparty' => ['nullable', 'string', 'max:255']];
    }
}
