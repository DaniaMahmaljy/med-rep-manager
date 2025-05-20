<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;


class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-zA-Z]/',  'regex:/[0-9]/',],
        ];
    }

     public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('password') && Auth::check()) {
                $currentPasswordHash = Auth::user()->password;

                if (Hash::check($this->password, $currentPasswordHash)) {
                    $validator->errors()->add(
                        'password',
                        'The new password cannot be the same as the old password.'
                    );
                }
            }
        });
    }

     public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain at least one letter, and one number.',
        ];
    }

    public function afterValidation()
    {
        $data = $this->validated();
        $data['user']= Auth::user();

        return $data;
    }
}
