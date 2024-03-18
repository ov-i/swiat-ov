<?php

namespace App\Rules;

use App\Services\Providers\GoogleRecaptchaService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ReCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('ReCaptcha token must be a string');
        }

        $googleRecaptcha = new GoogleRecaptchaService();
        if (!$googleRecaptcha->verify($value)) {
            $fail('Invalid ReCaptcha');
        }
    }
}
