<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<array-key, string>|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password(), 'confirmed', 'min:10'];
    }
}
