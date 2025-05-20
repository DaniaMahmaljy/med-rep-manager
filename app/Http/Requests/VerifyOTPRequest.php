<?php

namespace App\Http\Requests;

use App\Rules\VerifyOtpRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOTPRequest extends FormRequest
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
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'min:6', 'max:6', new VerifyOtpRule($this->email)],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-zA-Z]/',  'regex:/[0-9]/',],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain at least one letter, and one number.',
        ];
    }

}
