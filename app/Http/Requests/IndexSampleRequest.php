<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexSampleRequest extends FormRequest
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
            'group_by' => ['nullable', 'in:brand,sampleClass'],
            'search.value' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function filters()
    {
       $validated = $this->validated();

        return [
            'group_by' => $validated['group_by'] ?? 'brand',
            'search' => data_get($validated, 'search.value'),
            'user' => $this->user(),
            ];
    }
}
