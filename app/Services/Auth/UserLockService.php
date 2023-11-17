<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Enums\Auth\BanDurationEnum;
use App\Events\Auth\UserLocked;
use App\Events\Auth\UserUnlocked;
use App\Exceptions\AdminIsNotBlockableException;
use App\Exceptions\UserBlockHistoryRecordNotFoundException;
use App\Models\User;
use App\Notifications\NotifyUserAboutRisingLockDuration;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use Illuminate\Support\Carbon;

class UserLockService
{
    public function __construct(
        private readonly UserBlockHistoryRepository $userBlockHistoryRepository,
        private readonly AuthRepository $authRepository
    ) {}

    /**
     * Locks an user's account for a certain time.
     *
     * @param User& $user User that get's a ban
     * @param BanDurationEnum $duration Ban time
     *
     * @return bool
     * @throws AdminIsNotBlockableException if someone would try to lock a admin user
     */
    public function lockUser(User &$user, BanDurationEnum $duration): bool
    {
        if (true === $user->isAdmin()) {
            throw new AdminIsNotBlockableException($user);
        }

        if (false === $this->isMonthlyLockingSuspect($user)) {
            event(new UserLocked($user, $duration));

            return $this->authRepository->lockUser($user, $duration);
        }

        return $this->mothlyLocking($user);
    }

    /**
     * Unlocks the user, saves it to the history and sends notification.
     *
     * @param User& $user
     *
     * @return bool
     */
    public function unlockUser(User &$user): bool
    {
        if (true === $this->authRepository->unlockUser($user)) {
            event(new UserUnlocked($user));

            return true;
        }

        return false;
    }

    /**
     * Checks if user is blocked, if ban time has passed and if user is not banned 4ever.
     *
     * @param User& $user
     *
     * @return bool
     */
    public function isLockDurationOver(User &$user): bool
    {
        $time = Carbon::parse($this->authRepository->blockedUntil($user));

        return
            $user->isBlocked() &&
            $time->isPast() &&
            BanDurationEnum::forever()->value !== $user->ban_duration;
    }

    /**
     * Monthly locking algorithm. See docs to read more about this method
     *
     * @param User& $user Referenced user
     *
     * @return bool
     * @throws UserBlockHistoryRecordNotFoundException
     */
    public function mothlyLocking(User &$user): bool
    {
        if (true === $user->isBlocked()) {
            return false;
        }

        $blocksCount = $this->userBlockHistoryRepository
            ->getCount($user, null, BanDurationEnum::oneMonth());

        if (null === $blocksCount) {
            throw new UserBlockHistoryRecordNotFoundException(__('auth.user_block_history_not_found', [
                'user' => $user->name,
                'duration' => BanDurationEnum::oneMonth()->label,
            ]));
        }

        $lockDuration = $this->determinateLockDuration($blocksCount);
        if (BanDurationEnum::oneMonth() === $lockDuration) {
            $user->notify(new NotifyUserAboutRisingLockDuration($user));
        }

        return $this->authRepository->lockUser($user, $lockDuration);
    }

    /**
     * Checks if user is a suspect of monthly locking.
     *
     * @param User& $user
     *
     * @return bool
     */
    public function isMonthlyLockingSuspect(User &$user): bool
    {
        $blocksCount = $this->userBlockHistoryRepository
            ->getCount($user, null, BanDurationEnum::oneMonth());

        return $blocksCount > 1;
    }

    /**
     * Calculates the lock duration, based on algorithm of monthly locking
     *
     * @param int $lockDuration A predefined lock duration
     *
     * @return BanDurationEnum
     */
    private function determinateLockDuration(int $lockDuration): BanDurationEnum
    {
        if ($lockDuration === 1) {
            $duration = BanDurationEnum::oneMonth();
        } elseif ($lockDuration < 3) {
            $duration = BanDurationEnum::oneYear();
        } else {
            $duration = BanDurationEnum::forever();
        }

        return $duration;
    }
}
