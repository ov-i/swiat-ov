<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\LockReasonEnum;
use App\Enums\Auth\UserStatusEnum;
use App\Exceptions\CannotLockAlreadyLockedUserException;
use App\Exceptions\CannotUnlockNotLockedUserException;
use App\Exceptions\CannotUnlockPermamentLockException;
use App\Lib\Auth\LockOption;
use App\Models\User;
use App\Repositories\Eloquent\Auth\UserLockRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

describe('User Lock Repository', function () {
    beforeEach(function () {
        uses(RefreshDatabase::class);

        $this->userLockRepository = new UserLockRepository();
    });

    it('should be able to return user blocked until timestamp for locked user', function (User $user) {
        assert($user->isBlocked());

        $createdAt = Carbon::parse($user->created_at);
        $blockedFor = $createdAt->add($user->ban_duration);

        $banDuration = $blockedFor->format('Y-m-d H:i:s');

        $blockedUntil = $this->userLockRepository->blockedUntil($user);

        expect($blockedUntil)->toBeString();
        expect($banDuration)->toEqual($blockedUntil);
    })->with('locked-user');

    it('should be able to lock not already locked user', function (LockOption $lockOption, User $user) {
        $locked = $this->userLockRepository->lockUser($user, $lockOption);

        expect($user->fresh()->getStatus())->toEqual(UserStatusEnum::banned()->value);
        expect($user->fresh()->ban_duration)->toBeString(BanDurationEnum::oneDay()->value);
        expect($user->fresh()->lock_reason)->toBeString(LockReasonEnum::hackingAttempt()->value);
        expect($locked)->toBeTrue();
    })->with('lock-option', 'custom-user');

    it('should NOT be be able to lock already locked user', function (LockOption $lockOption, User $user) {
        $this->expectException(CannotLockAlreadyLockedUserException::class);

        $locked = $this->userLockRepository->lockUser($user, $lockOption);

        expect($locked)->toThrow(CannotLockAlreadyLockedUserException::class);
    })->with('lock-option', 'locked-user');

    it('should be able to unlock currently locked user', function (User $user) {
        $unlocked = $this->userLockRepository->unlockUser($user);

        expect($unlocked)->toBeTrue();
        expect($user->fresh()->getStatus())->toBe(UserStatusEnum::active()->value);
        expect($user->fresh()->ban_duration)->toBeNull();
        expect($user->fresh()->banned_at)->toBeNull();
        expect($user->fresh()->lock_reason)->toBeNull();
    })->with('locked-user');

    it('should NOT be able to unlocked permament locked user', function (User $user) {
        $this->expectException(CannotUnlockPermamentLockException::class);

        $unlocked = $this->userLockRepository->unlockUser($user);

        expect($unlocked)->toThrow(CannotUnlockPermamentLockException::class);
    })->with('permament-locked-user');

    it('should not be able to unlock the NOT locked user', function (User $user) {
        $this->expectException(CannotUnlockNotLockedUserException::class);

        $unlocked = $this->userLockRepository->unlockUser($user);

        expect($unlocked)->toThrow(CannotUnlockNotLockedUserException::class);
    })->with('custom-user');
});
