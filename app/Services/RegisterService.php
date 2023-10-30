<?php

namespace App\Services;

use App\Actions\Fortify\PasswordValidationRules;
use App\Data\Auth\RegisterRequestData;
use App\Models\User;
use App\Repositories\Eloquent\Auth\RegisterRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

class RegisterService extends Service
{
    use PasswordValidationRules;

    public function __construct(
        private readonly RegisterRepository $authRepository,
    ) {
    }

    /**
     * @inheritdoc
     */
    protected function defineSchema(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ];
    }

    /**
     * Creates new user and validates registration data
     *
     * @param array<array-key, mixed>|RegisterRequestData $requestData
     *
     * @return User
     * @throws ValidationException
     */
    public function create(array|RegisterRequestData $requestData): User
    {
        $this->validateRequest($requestData);

        return $this->authRepository->createUser([
            ...$requestData,
            'ip' => Request::ip(),
        ]);
    }
}
