<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class Service
{
    /**
     * Defines request's schema, that should be validated.
     *
     * @return array<array-key, mixed>
     */
    abstract protected function defineSchema(): array;

    /**
     * Validates requests against it's data.
     *
     * @param array<array-key, mixed> $requestData
     *
     * @return array<array-key, mixed>
     * @throws ValidationException
     */
    protected function validateRequest(array $requestData): array
    {
        return Validator::make($requestData, $this->defineSchema())
            ->validate();
    }
}
