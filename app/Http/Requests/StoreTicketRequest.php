<?php

namespace App\Http\Requests;

use App\Enums\TicketableEnum;
use App\Enums\TicketPriorityEnum;
use App\Rules\TicketableExistsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:65000'],
            'priority' => ['nullable', Rule::in(array_column(TicketPriorityEnum::cases(), 'value'))],
            'ticketable_type' => ['nullable', Rule::in(array_column(TicketableEnum::cases(), 'name'))],
            'ticketable_id' => ['required_with:ticketable_type', new TicketableExistsRule($this->ticketable_type)]
        ];
    }

     public function afterValidation()
    {
        $data = $this->validated();
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $data['ticketable_type'] = TicketableEnum::fromName($data['ticketable_type'])->value;
        return $data;
    }

}
