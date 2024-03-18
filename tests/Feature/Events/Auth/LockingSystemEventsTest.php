<?php

use App\Enums\Auth\BanDurationEnum;
use App\Events\Auth\UserLocked;
use App\Events\Auth\UserUnlocked;
use App\Lib\Auth\LockOption;
use App\Listeners\Auth\SaveLockToHistory;
use App\Listeners\Auth\SaveUnlockToHistory;
use App\Listeners\Auth\SendLockNotification;
use App\Listeners\Auth\SendUnlockNotification;
use App\Models\User;
use App\Repositories\Eloquent\Auth\UserLockRepository;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use App\Services\Auth\UserLockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class, WithFaker::class);

describe('Locking System', function () {
    beforeEach(function () {
        $userBlockHistoryRepository = mock(UserBlockHistoryRepository::class);
        $userBlockHistoryRepository->shouldReceive('historyRecordsCount')
            ->andReturn(0);

        $this->userLockRepository = mock(UserLockRepository::class);

        $this->userLockService = new UserLockService(
            $userBlockHistoryRepository,
            $this->userLockRepository,
        );

        $this->lockOption = new LockOption(
            lockDuration: BanDurationEnum::oneDay(),
            reason: 'testing purpose'
        );
    });

    test('The [UserLocked] event is being listened by SendLockNotification', function () {
        Event::fake();

        Event::assertListening(UserLocked::class, SendLockNotification::class);
    });

    test('The [UserLocked] event has a SaveLockToHistory listener', function () {
        Event::fake();

        Event::assertListening(UserLocked::class, SaveLockToHistory::class);
    });

    test('The [UserUnlocked] event has a SendUnlockNotification listener', function () {
        Event::fake();

        Event::assertListening(UserUnlocked::class, SendUnlockNotification::class);
    });

    test('The [UserUnlocked] event has a SaveUnlockToHistory listener', function () {
        Event::fake();

        Event::assertListening(UserUnlocked::class, SaveUnlockToHistory::class);
    });

    test("The [UserLocked] event is being dispatched after user is locked", function () {
        $this->userLockRepository
            ->shouldReceive('lockUser')
            ->andReturnTrue();

        $user = User::factory()->create();

        assert(!$user->isBlocked());

        Event::fake();

        $this->userLockService->lockUser($user, $this->lockOption);

        Event::assertDispatched(UserLocked::class);
    });

    test(
        'The [SendLockNotification] is being send to the user after [UserLocked] event is dispatched',
        function () {
            $this->userLockRepository
                ->shouldReceive('lockUser')
                ->andReturnTrue();

            $this->markTestIncomplete("Needs further improvements for listener testing");

            $user = User::factory()->create();

            Notification::fake();

            $locked = $this->userLockService->lockUser($user, $this->lockOption);

            assertTrue($locked);

            Notification::assertSentTo($user, SendLockNotification::class);
        }
    );

    test('The [UserUnlocked] event is being dispatched if user can be unlocked', function () {
        $this->userLockRepository->shouldReceive('unlockUser')
                    ->andReturnTrue();

        $user = User::factory()->locked()->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->getEmail(),
            'ban_duration' => BanDurationEnum::oneDay()->value
        ]);

        Event::fake();

        $unlocked = $this->userLockService->unlockUser($user);

        assertTrue($unlocked);

        Event::assertDispatched(UserUnlocked::class);
    });
});
