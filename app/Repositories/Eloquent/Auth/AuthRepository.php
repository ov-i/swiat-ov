<?php

namespace App\Repositories\Eloquent\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;

class AuthRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param array<string, string>|RegisterRequestData $requestData
     * @return User|null
     */
    public function createUser(array|RegisterRequestData $requestData): ?User
    {
        /** @phpstan-ignore-next-line */
        return $this->create($requestData);
    }
}
