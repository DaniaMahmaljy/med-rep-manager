<?php

namespace App\Http\Requests;

use App\Enums\SampleVisitStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompleteVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         return $this->user()->can('update', $this->route('visit'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'samples' => ['required', 'array'],
            'samples.*.id' => ['required', 'exists:sample_visit,sample_id'],
            'samples.*.status' => ['required', Rule::enum(SampleVisitStatus::class)],
            'samples.*.quantity_used' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function afterValidation(): array
    {
        $data = $this->validated();
        $data['visit_id'] = $this->route('visit')->id;
        $data['user_id'] = $this->user()->id;
        return $data;
    }
}
