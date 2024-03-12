<?php

namespace App\Repositories\Eloquent\Users;

use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
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
        return $this->findAllBy('status', $status);
    }

    public function deleteUser(User &$user, bool $forceDelete = false): void
    {
        $this->delete($user, $forceDelete);
    }
}
