<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\LockReasonEnum;
use App\Lib\Auth\LockOption;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\Auth\UserLockRepository;
use App\Services\Auth\UserLockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use function Pest\Laravel\actingAs;

describe('User blocking system', function () {
    uses(RefreshDatabase::class, WithFaker::class);
    beforeEach(function () {
        $this->authRepository = new UserLockRepository();
        $this->userLockService = app(UserLockService::class);
    });

    it('should be able to lock user\'s account', function (BanDurationEnum $banDuration) {
        actingAs($user = User::factory()->create()->fresh());

        $lockOption = new LockOption($banDuration, LockReasonEnum::highFraudScore());

        $locked = $this->userLockService->lockUser($user, $lockOption);

        expect($locked)->toBeTrue();
        expect($user->isBlocked())->toBeTrue();
        expect($user->banned_at)->not()->toBeNull();
    })->with('ban_durations');

    test('locked user should have ban duration NOT set to null', function () {
        actingAs($user = User::factory()->locked(BanDurationEnum::oneDay())->create()->fresh());

        $blockedUntil = $this->authRepository->blockedUntil($user);

        expect($blockedUntil)->not()->toBeNull();
        expect($blockedUntil)->toBeString();
    });

    it('should be able to unlock user\'s account', function () {
        actingAs($user = User::factory()->locked(BanDurationEnum::oneDay())->create()->fresh());

        $unLocked = $this->userLockService->unlockUser($user);

        expect($unLocked)->toBeTrue();
        expect($user->isBlocked())->toBeFalse();
        expect($user->banned_at)->toBeNull();
    });

    test('unlocked user should have ban duration set to null', function () {
        actingAs($user = User::factory()->create());

        $blockedUntil = $this->authRepository->blockedUntil($user);

        expect($blockedUntil)->toBeNull();
    });

    it('should lock user by increasing lock duration', function (User $user, BanDurationEnum $duration) {
        $admin = User::factory()
            ->has(UserBlockHistory::factory())
            ->create();

        actingAs($admin);

        $lockOption = new LockOption($duration, LockReasonEnum::monthlyLocking()->value);

        $locked = $this->userLockService->lockUser($user, $lockOption);

        expect($locked)->toBeTrue();
        expect($user->ban_duration->value)->toBeString(BanDurationEnum::oneMonth()->value);
    })->with([
        [fn () => User::factory()->create([
            'name' => fake()->userName(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]), BanDurationEnum::oneMonth()]
    ]);
});
