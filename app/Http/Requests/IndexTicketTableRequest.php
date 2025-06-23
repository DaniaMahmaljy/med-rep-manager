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
            'search' => 'nullable|string|max:255',
            'draw' => 'sometimes|numeric',
            'start' => 'sometimes|numeric',
            'length' => 'sometimes|numeric',
        ];
    }

    public function filters()
    {
        $validated = $this->validated();

        return [
            'group_by' => $validated['group_by'] ?? 'created_at',
            'search' => $validated['search'] ?? null,
            'date_from' => $validated['date_from'] ?? null,
            'date_to' => $validated['date_to'] ?? null,
            'auth_user' => $this->user(),
            'draw' => $validated['draw'] ?? null,
            'start' => $validated['start'] ?? 0,
            'length' => $validated['length'] ?? 10,
        ];
    }
}
