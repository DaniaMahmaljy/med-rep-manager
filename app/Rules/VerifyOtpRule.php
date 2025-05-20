<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Cache;


class VerifyOtpRule implements ValidationRule
{
    protected $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $otp = Cache::get($this->email, null);
        if(!$otp || $otp != $value){
            $fail('The provided otp is invalid.');
        }
    }
}
