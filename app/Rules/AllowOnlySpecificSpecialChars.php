<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowOnlySpecificSpecialChars implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $matches = preg_match('/^[\wa\.,!\?\s-]*$/u', $value);

        if (!$matches) {
            $fail(__("The $attribute may only contain Letters, Digits, (?), (!), (,), (.), and space"));
        }
    }
}
