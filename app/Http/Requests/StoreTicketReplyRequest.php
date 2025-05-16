<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return $this->user()->can('addReply', $this->route('ticket'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
         'reply' => ['required', 'string', 'max:65000'],
        ];
    }

     public function afterValidation()
    {
        $data = $this->validated();
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $data['ticket_id'] = $this->route('ticket')->id;
        return $data;
    }
}



