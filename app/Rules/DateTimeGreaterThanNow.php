<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class DateTimeGreaterThanNow implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currentDateTime = now()->format('Y-m-d H:i');
        $inputDateTime = Carbon::parse($value)->format('Y-m-d H:i');

        if ($inputDateTime < $currentDateTime) {
            $fail(__("The $attribute field must NOT be set to past date time."));
        } elseif ($inputDateTime <= $currentDateTime) {
            $fail(__("Cannot delay publishing with current date time usage"));
        }
    }
}
