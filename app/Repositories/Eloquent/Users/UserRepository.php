<?php

namespace App\Repositories\Eloquent\Users;

use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository
{
    /**
     * Summary of __construct
     * @param \App\Models\User $user
     */
    public function __construct(
        User $user
    ) {
        parent::__construct($user);
    }

    public function getAllUsers(): ?LengthAwarePaginator
    {
        return $this->all();
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
