<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('addNote', $this->route('visit'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:65000'],
        ];
    }

      public function afterValidation()
    {
        $user = auth()->user();
        $data = $this->validated();
        $data['visit_id'] = $this->route('visit')->id;
        $data['user_id'] = $user->id;
        return $data;
    }

}
