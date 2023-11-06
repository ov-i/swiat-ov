<?php

namespace App\Actions\Fortify;

use App\Data\Auth\RegisterRequestData;
use App\Models\User;
use App\Notifications\VerifyEmail;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        $input = RegisterRequestData::from([
            ...$input,
            'ip' => Request::ip(),
        ]);
        $user = $this->authService->create($input);
        $user->notify(new VerifyEmail());

        return $user;
    }
}
