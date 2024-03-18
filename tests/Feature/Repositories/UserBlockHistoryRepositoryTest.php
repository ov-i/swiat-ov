<?php

use App\Data\Auth\CreateUserBlockHistoryData;
use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

describe('User Block History Repository', function () {
    it('should be able to create a history record', function (
        User &$user,
        UserBlockHistoryActionEnum $action,
        ?BanDurationEnum $duration = null
    ) {
        actingAs($operator = User::factory()->create());

        $userBlockHistoryRepository = new UserBlockHistoryRepository();

        $data = new CreateUserBlockHistoryData(
            userId: $user->getKey(),
            action: $action,
            banDuration: $duration,
            operatorId: $operator->getKey(),
        );

        $blockHistory = $userBlockHistoryRepository->addToHistory($data);

        expect($blockHistory)->toBeInstanceOf(UserBlockHistory::class);
    })->with('user_block_histories');

    describe('History Records Count method', function () {
        it('should return count with default parameters', function (int $count) {
            $user = User::factory()
                ->has(UserBlockHistory::factory()->count($count))
                ->dummy()
                ->create();

            $blockRepository = new UserBlockHistoryRepository();

            $lockHistoryCount = $blockRepository->historyRecordsCount($user);

            expect($lockHistoryCount)->toBeInt();
            expect($lockHistoryCount)->toBeGreaterThan(0);
        })->with([1, 2, 3]);

        it('should return count with specified action', function (UserBlockHistoryActionEnum $action) {
            $user = User::factory()
                ->has(UserBlockHistory::factory()->count(10))
                ->dummy()
                ->create();

            $lockHistoryCount = getRecordsCount($user, action: $action);

            expect($lockHistoryCount)->toBeInt();
            expect($lockHistoryCount)->toBeGreaterThan(0);
        })->with([UserBlockHistoryActionEnum::cases()]);

        it('should return count with action [locked] and ban duration specified', function (
            BanDurationEnum $banDurationEnum
        ) {
            $user = createLockedUser($banDurationEnum);

            $lockHistoryCount = getRecordsCount($user, action: UserBlockHistoryActionEnum::locked(), banDuration: $banDurationEnum);

            expect($lockHistoryCount)->toBe(1);
        })->with([BanDurationEnum::cases()]);

        it('should return count with action [unlocked] specified', function () {
            $user = createUnlockedUser();

            $lockHistoryCount = getRecordsCount($user, action: UserBlockHistoryActionEnum::unlocked());

            expect($lockHistoryCount)->toBe(1);
        });

        it('throws a LogicException if action equals [unlocked] and ban duration is declared', function () {
            $user = createUnlockedUser();

            $this->expectException(\LogicException::class);
            $lockHistoryCount = getRecordsCount($user, action: UserBlockHistoryActionEnum::unlocked(), banDuration: BanDurationEnum::oneDay());

            expect($lockHistoryCount)->toThrow(\LogicException::class);
        });
    });

    function getRecordsCount(
        User &$user,
        ?UserBlockHistoryActionEnum $action = null,
        ?BanDurationEnum $banDuration = null
    ): int {
        $blockRepostory = new UserBlockHistoryRepository();

        return $blockRepostory->historyRecordsCount($user, $action, $banDuration);
    }

    function createLockedUser(BanDurationEnum $banDuration): User
    {
        return User::factory()
            ->has(UserBlockHistory::factory()->locked($banDuration))
            ->dummy()
            ->create();
    }

    function createUnlockedUser(): User
    {
        return  User::factory()
            ->has(UserBlockHistory::factory()->unlocked())
            ->dummy()
            ->create();
    }
});
