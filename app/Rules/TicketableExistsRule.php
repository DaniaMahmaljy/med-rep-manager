<?php

namespace App\Rules;

use App\Enums\TicketableEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TicketableExistsRule implements ValidationRule
{

     public function __construct(protected $ticketable_type)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ticketable_class = TicketableEnum::fromName($this->ticketable_type)->value;
        if(!$ticketable_class::where('id', $value)->exists()){
            $fail("ticketable id for ticketable {$this->ticketable_type} does not exists");
        }
    }
}
