<?php

namespace App\Repositories\Eloquent\Users;

use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @param string|int $userId
     *
     * @return User|null
     */
    public function findUserById($userId)
    {
        /** @phpstan-ignore-next-line */
        return $this->find($userId);
    }

    /**
     * @param UserStatusEnum $status
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public function getUsersByStatus($status)
    {
        return $this->findAllBy('status', $status);
    }

    /**
     * @param User $user
     * @param bool $forceDelete
     *
     * @return void
     */
    public function deleteUser(&$user, $forceDelete = false)
    {
        $this->delete($user, $forceDelete);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return User::class;
    }
}
