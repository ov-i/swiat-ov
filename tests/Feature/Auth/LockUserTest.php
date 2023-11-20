<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use App\Services\Auth\UserLockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

describe('User blocking system', function () {
    beforeEach(function () {
        $user = mock(User::class);
        $blockHistoryRepository = mock(UserBlockHistoryRepository::class);
        $blockHistoryRepository->shouldReceive('getCount');

        $this->authRepository = new AuthRepository($user);
        $this->userLockService = new UserLockService($blockHistoryRepository, $this->authRepository);
    });

    it('should be able to lock user\'s account', function (string $banDuration) {
        $this->actingAs($user = User::factory()->create()->fresh());

        $banDuration = BanDurationEnum::from($banDuration);

        $locked = $this->userLockService->lockUser($user, $banDuration);

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

        $unLocked = $this->userLockService->unlockUser($user);

        expect($unLocked)->toBeTrue();
        expect($user->isBlocked())->toBeFalse();
        expect($user->banned_at)->toBeNull();
    });

    test('unlocked user should have ban duration set to null', function () {
        $this->actingAs($user = User::factory()->create()->fresh());

        $blockedUntil = $this->authRepository->blockedUntil($user);

        expect($blockedUntil)->toBeNull();
    });

    it('should lock user by increasing lock duration', function (User $user, BanDurationEnum $duration) {
        UserBlockHistory::factory()->for($user)->create([
            'action' => UserBlockHistoryActionEnum::locked()->value,
            'ban_duration' => $duration
        ]);

        $locked = $this->userLockService->lockUser($user, $duration);

        expect($locked)->toBeTrue();
        expect($user->ban_duration)->toBeString(BanDurationEnum::oneMonth()->value);
    })->with([
        [fn () => User::factory()->create([
            'name' => fake()->userName(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]), BanDurationEnum::oneMonth()]
    ]);
});
