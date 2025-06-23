<?php

namespace App\Http\Requests;

use App\Enums\SampleUnitEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSampleRequest extends FormRequest
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
             'name' => ['required', 'array'],
             "name.en" => ['required', 'string', 'min:3', 'max:255'],
             "name.ar" => ['required', 'string', 'min:3', 'max:255'],
             'brand_id' => ['required',  'numeric', 'exists:brands,id'],
             'sample_class_id' => ['required',  'numeric', 'exists:sample_classes,id'],
             'unit' => ['required', Rule::enum(SampleUnitEnum::class)],
             'specialty_ids' => ['nullable', 'array'],
             'specialty_ids.*' => ['exists:specialties,id'],
             'quantity_available' => ['required', 'numeric', 'min:1'],
             'expiration_date' => ['required', 'date', 'after_or_equal:today']
        ];

    }
}
