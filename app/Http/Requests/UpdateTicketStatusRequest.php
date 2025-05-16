<?php

namespace App\Http\Requests;

use App\Enums\TicketStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
         $result = $this->user()->can('update', $ticket);

        \Log::info('Authorization check', [
        'user_id' => $this->user()->id,
        'ticket_id' => $ticket->id,
        'result' => $result,
    ]);

        return $this->user()->can('update', $this->route('ticket'));
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'status' => ['required', Rule::in(array_column(TicketStatusEnum::cases(), 'value'))],
        ];
    }

    public function afterValidation()
    {
        $data = $this->validated();
        $data['ticket_id'] = $this->route('ticket')->id;
        return $data;
    }

}
