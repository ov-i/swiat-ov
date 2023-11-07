<?php

namespace App\Repositories\Eloquent\Users;

use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(
        User $user
    ) {
        parent::__construct($user);
    }

    /**
     * @return User|null
     */
    public function findUserById(string|int $userId): ?User
    {
        /** @phpstan-ignore-next-line */
        return $this->find($userId);
    }
}
