<?php

namespace App\Rules;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotRepresentativeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('username', $value)->first();

        if ($user && $user->userable_type === UserTypeEnum::REPRESENTATIVE->value) {
            $fail('Unauthorized');
        }
    }
}
