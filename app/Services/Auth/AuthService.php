<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Enums\Auth\RoleNamesEnum;
use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;
use Illuminate\Support\Facades\Request;

class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
    ) {
    }

    /**
     * Creates new user and validates registration data
     *
     * @param RegisterRequestData $requestData
     *
     * @return User
     * @throws ValidationException
     */
    public function create(RegisterRequestData $requestData): User
    {
        /** @var User $user */
        $user = $this->authRepository->createUser([
            ...$requestData->toArray(),
            'ip' => Request::ip(),
        ]);

        $user->assignRole(RoleNamesEnum::user()->value);

        return $user;
    }
}