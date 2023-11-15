<?php

use App\Enums\Auth\BanDurationEnum;
use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;

describe('User blocking system', function () {
    beforeEach(function () {
        $user = mock(User::class);

        $this->authRepository = new AuthRepository($user);
    });

    it('should be able to lock user\'s account', function (string $banDuration) {
        $this->actingAs($user = User::factory()->create()->fresh());

        $banDuration = BanDurationEnum::from($banDuration);

        $locked = $this->authRepository->lockUser($user, $banDuration);

        expect($locked)->toBeTrue();
        expect($user->isBlocked())->toBeTrue();
        expect($user->banned_at)->not()->toBeNull();
    })->with('ban_durations');

    test('locked user should have ban duration NOT set to null', function () {
        $this->actingAs($user = User::factory()->locked()->create()->fresh());

        $blockedUntil = $this->authRepository->blockedUntil($user);

        expect($blockedUntil)->not()->toBeNull();
        expect($blockedUntil)->toBeString();
    });

    it('should be able to unlock user\'s account', function () {
        $this->actingAs($user = User::factory()->locked()->create()->fresh());

        $unLocked = $this->authRepository->unlockUser($user);

        expect($unLocked)->toBeTrue();
        expect($user->isBlocked())->toBeFalse();
        expect($user->banned_at)->toBeNull();
    });

    test('unlocked user should have ban duration set to null', function () {
        $this->actingAs($user = User::factory()->create()->fresh());
        
        $blockedUntil = $this->authRepository->blockedUntil($user);

        expect($blockedUntil)->toBeNull();
    });
});
