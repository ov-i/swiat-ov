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
use App\Services\Auth\UserLockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class, WithFaker::class);

describe('Locking System', function () {
    beforeEach(function () {
        $this->userLockService = app(UserLockService::class);
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

    test("The [UserLocked] event is being dispatched after user is locked", function (LockOption $lockOption, User $user) {
        assert(!$user->isBlocked());

        Event::fake();

        $this->userLockService->lockUser($user, $lockOption);

        Event::assertDispatched(UserLocked::class);
    })->with('lock-option', 'custom-user');

    test(
        'The [SendLockNotification] is being send to the user after [UserLocked] event is dispatched',
        function (LockOption $lockOption) {
            $this->markTestIncomplete("Needs further improvements for listener testing");

            $user = User::factory()->create();

            Notification::fake();

            $locked = $this->userLockService->lockUser($user, $lockOption);

            assertTrue($locked);

            Notification::assertSentTo($user, SendLockNotification::class);
        }
    )->with('lock-option');

    test('The [UserUnlocked] event is being dispatched if user can be unlocked', function (User $user) {
        $this->assertDatabaseHas('users', [
            'email' => $user->getEmail(),
            'ban_duration' => BanDurationEnum::oneDay()->value
        ]);

        Event::fake();

        $unlocked = $this->userLockService->unlockUser($user);

        assertTrue($unlocked);

        Event::assertDispatched(UserUnlocked::class);
    })->with('locked-user');
});
