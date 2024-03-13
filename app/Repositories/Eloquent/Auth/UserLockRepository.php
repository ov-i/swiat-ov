<?php

namespace App\Repositories\Eloquent\Auth;

use App\Enums\Auth\UserStatusEnum;
use App\Events\Auth\UserLocked;
use App\Exceptions\AdminIsNotBlockableException;
use App\Exceptions\CannotLockAlreadyLockedUserException;
use App\Exceptions\CannotUnlockNotLockedUserException;
use App\Exceptions\CannotUnlockPermamentLockException;
use App\Lib\Auth\LockOption;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Carbon;

class UserLockRepository extends BaseRepository
{
    /**
     * Calculates the user's lock interval.
     *
     * @return string|null Returns null if user is NOT blocked.
     */
    public function blockedUntil(User &$user)
    {
        if (false === $user->isBlocked()) {
            return null;
        }

        $createdAt = Carbon::parse($user->banned_at);
        $blockedUntil = $createdAt->add($user->ban_duration);

        return $blockedUntil->format('Y-m-d H:i:s');
    }

    /**
     * @throws AdminIsNotBlockableException
     */
    public function lockUser(User &$user, LockOption $lockOption): bool
    {
        if (true === $user->isBlocked()) {
            throw new CannotLockAlreadyLockedUserException();
        }

        $locked = false === $user->isBlocked() && $user->update([
            'status' => UserStatusEnum::banned()->value,
            'ban_duration' => $lockOption->getDuration(),
            'banned_at' => now(),
            'lock_reason' => $lockOption->getReason()
        ]);

        event(new UserLocked($user, $lockOption));
        return $locked;
    }

    /**
     * @throws CannotUnlockPermamentLockException If someone tries to unlock permament lock
     * @throws CannotUnlockNotLockedUserException It's impossible to unlock not locked user.
     */
    public function unlockUser(User &$user): bool
    {
        if (false === $user->canBeUnlocked()) {
            throw new CannotUnlockPermamentLockException();
        }

        if (false === $user->isBlocked()) {
            throw new CannotUnlockNotLockedUserException();
        }

        return $user->update([
            'status' => UserStatusEnum::active()->value,
            'ban_duration' => null,
            'banned_at' => null,
            'lock_reason' => null,
        ]);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return User::class;
    }
}
