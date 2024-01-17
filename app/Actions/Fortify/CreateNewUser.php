<?php

namespace App\Actions\Fortify;

use App\Data\Auth\RegisterRequestData;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\Auth\AuthService;
use App\Services\Auth\UserLockService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Symfony\Component\HttpFoundation\IpUtils;

class CreateNewUser implements CreatesNewUsers
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserRepository $userRepository,
        private readonly UserLockService $userLockService,
    ) {
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param array<array-key, string> $input
     * @return User
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        $input = RegisterRequestData::from([
            ...$input,
            'ip' => IpUtils::anonymize(Request::ip()) // GDPR compl.
        ]);

        $user = $this->authService->create($input);
        
        event(new Registered($user));

        return $user;
    }
}
