<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;

describe('User blocking system', function () {
    beforeEach(function () {
        $this->authRepository = mock(AuthRepository::class);
    });

    it('should be able to lock user\'s account', function (string $banDuration) {
        $this->actingAs($user = User::factory()->create()->fresh());

        $this->authRepository->shouldReceive('lockUser')
            ->atLeast()
            ->once()
            ->andReturnUsing(function (User $user, string $banDuration) {
                $user->status = UserStatusEnum::banned();
                $user->ban_duration = $banDuration;
                $user->banned_at = now();
                $user->save();

                return true;
            });

        $this->authRepository->shouldReceive('blockedUntil')
            ->atLeast()
            ->once()
            ->andReturn(BanDurationEnum::class);

        $banDuration = BanDurationEnum::from($banDuration);

        $locked = $this->authRepository->lockUser($user, $banDuration);

        $user = $user->refresh();

        expect($locked)->toBeTrue();
        expect($user->isBlocked())->toBeTrue();
        expect($user->banned_at)->not()->toBeNull();
        expect($this->authRepository->blockedUntil($user))->toBeString();
    })->with(BanDurationEnum::toArray());

    it('should be able to unlock user\'s account', function () {
        $this->actingAs($user = User::factory()->locked()->create()->fresh());

        $this->authRepository->shouldReceive('unlockUser')
            ->atLeast()
            ->once()
            ->andReturnUsing(function (User $user) {
                $user->status = UserStatusEnum::active();
                $user->banned_at = null;
                $user->ban_duration = null;
                $user->save();

                return true;
            });


        $this->authRepository->shouldReceive('blockedUntil')
            ->once()
            ->andReturn(null);


        $unLocked = $this->authRepository->unlockUser($user);
        $user = $user->fresh();

        expect($unLocked)->toBeTrue();
        expect($user->isBlocked())->toBeFalse();
        expect($user->banned_at)->toBeNull();
        expect($user->ban_duration)->toBeNull();
        expect($this->authRepository->blockedUntil($user))->toBeNull();
    });
});
