<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
             "first_name" => ['required', 'string', 'min:3', 'max:255'],
             "last_name" => ['required', 'string', 'min:3', 'max:255'],
             'municipal_id' => ['required',  'numeric', 'exists:municipals,id'],
             'specialty_id' => ['required',  'numeric', 'exists:specialties,id'],
             'phone' => ['required', 'string', 'regex:/^\+?[0-9\s\-().]{7,20}$/'],
             'address' => ['nullable', 'string', 'max:1000'],
             'latitude' => ['required', 'numeric', 'between:-90,90'],
             'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }
}
