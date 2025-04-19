<?php

namespace App\Http\Requests;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can( 'create', [User::class, $this->input('user_type')] );
    }





    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "first_name" => ['required', 'string', 'min:3', 'max:255'],
            "last_name" => ['required', 'string', 'min:3', 'max:255'],
            "email" => ['required','email', 'unique:users,email', 'max:255'],
            'user_type' => ['required',Rule::in(array_column(UserTypeEnum::cases(), 'value'))],
        ];

        $user_type = $this->input('user_type');


        if ($user_type === UserTypeEnum::SUPERVISOR->value) {
            $rules['city_id'] = ['required',  'numeric', 'exists:cities,id'];
        }

        elseif ($user_type === UserTypeEnum::REPRESENTATIVE->value) {
            $rules['municipal_id'] = ['required',  'numeric', 'exists:municipals,id'];
            $rules['latitude'] = ['required', 'numeric', 'between:-90,90'];
            $rules['longitude'] = ['required', 'numeric', 'between:-180,180'];
            $rules['address'] = ['nullable', 'string', 'max:1000'];
        }
        return $rules;
    }
}
