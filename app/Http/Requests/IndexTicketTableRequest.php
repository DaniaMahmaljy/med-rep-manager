<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexTicketTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_by' => 'nullable|in:user,created_at,status,priority',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'search.value' => 'nullable|string|max:255',
        ];
    }

    public function filters()
    {
        $validated = $this->validated();

        return [
            'group_by' => $validated['group_by'] ?? 'user',
            'search' => data_get($validated, 'search.value'),
            'date_from' => $validated['date_from'] ?? null,
            'date_to' => $validated['date_to'] ?? null,
            'auth_user' => $this->user(),
            ];
    }
}
