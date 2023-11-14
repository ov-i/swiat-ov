<?php

namespace App\Repositories\Eloquent\Users;

use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @return LengthAwarePaginator<User>|null
     */
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

    /**
     * @return Collection<int, User>
     */
    public function getUsersByStatus(UserStatusEnum $status): Collection
    {
        return $this->getModel()->where("status", $status)->get();
    }

    public function getUserStatus(User &$user): string
    {
        return $user->status;
    }
}
