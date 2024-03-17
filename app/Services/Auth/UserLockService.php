<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\LockReasonEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Events\Auth\UserLocked;
use App\Events\Auth\UserUnlocked;
use App\Exceptions\AdminIsNotBlockableException;
use App\Exceptions\UserBlockHistoryRecordNotFoundException;
use App\Lib\Auth\LockOption;
use App\Models\User;
use App\Notifications\NotifyUserAboutRisingLockDuration;
use App\Repositories\Eloquent\Auth\UserLockRepository;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use Illuminate\Support\Carbon;

class UserLockService
{
    public function __construct(
        private readonly UserBlockHistoryRepository $userBlockHistoryRepository,
        private readonly UserLockRepository $userLockRepository
    ) {
    }

    /**
     * Locks an user's account for a certain time.
     *
     * @throws AdminIsNotBlockableException if someone would try to lock a admin user.
     */
    public function lockUser(User &$user, LockOption $lockOption): bool
    {
        if ($user->isAdmin()) {
            throw new AdminIsNotBlockableException($user);
        }
        
        $locked = $this->mothlyLocking($user, $lockOption);

        event(new UserLocked($user, $lockOption));

        return $locked;
    }

    /**
     * Unlocks the user, saves it to the history and sends notification.
     *
     * @param User $user
     *
     * @return bool
     */
    public function unlockUser(User &$user)
    {
        if ($this->userLockRepository->unlockUser($user)) {
            event(new UserUnlocked($user));

            return true;
        }

        return false;
    }

    /**
     * Checks if user is blocked, if ban time has passed and if user is not banned 4ever.
     */
    public function isLockDurationOver(User &$user): bool
    {
        $time = Carbon::parse($this->userLockRepository->blockedUntil($user));

        return
            $user->isBlocked() &&
            $time->isPast() &&
            $user->canBeUnlocked();
    }

    /**
     * Monthly locking algorithm. See docs to read more about this method.
     *
     * @throws UserBlockHistoryRecordNotFoundException
     */
    public function mothlyLocking(User &$user, LockOption $lockOption): bool
    {
        if (!$this->isMonthlyLockingSuspect($user)) {
            return $this->userLockRepository->lockUser($user, $lockOption);
        }
        
        $lockReason = LockReasonEnum::monthlyLocking()->value;
        $oneMonthCount = $this->getLockCount($user, BanDurationEnum::oneMonth());
        $yearlyMonthCount = $this->getLockCount($user, BanDurationEnum::oneYear());

        if ($oneMonthCount === 2 && $yearlyMonthCount === 0) {
            $user->notify(new NotifyUserAboutRisingLockDuration($user));
        }

        $lockOption = $yearlyMonthCount === 1 ?
            new LockOption(BanDurationEnum::forever(), $lockReason) :
            new LockOption(BanDurationEnum::oneYear(), $lockReason);

        return $this->userLockRepository->lockUser($user, $lockOption);
    }

    /**
     * Checks if user is a suspect of monthly locking.
     */
    public function isMonthlyLockingSuspect(User &$user): bool
    {
        $monthHistory = $this->getLockCount($user, BanDurationEnum::oneMonth());

        return $monthHistory < 3 && $monthHistory > 1;
    }

    /**
     * Gets user locks count history from the given duration.
     */
    public function getLockCount(User &$user, BanDurationEnum $duration): int
    {
        return $this->userBlockHistoryRepository
            ->historyRecordsCount($user, UserBlockHistoryActionEnum::locked(), $duration);
    }
}
