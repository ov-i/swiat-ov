<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Exceptions\InvalidUserBlockHistoryRecordException;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;

describe('Saving user block histories system', function() {
    beforeEach(function() {
        $userBlock = mock(UserBlockHistory::class);

        $userBlock->shouldReceive('query')
            ->andReturnSelf();

        $userBlock->shouldReceive('create')
            ->andReturnSelf();

        $this->userBlockHistoryRepository = new UserBlockHistoryRepository($userBlock);
    });

    it('should be able to save history', function (
        User& $user, 
        UserBlockHistoryActionEnum $action, 
        ?BanDurationEnum $duration = null
    ) {
        $blockHistory = $this->userBlockHistoryRepository->addHistoryFrom($user, $action, $duration);
    
        expect($blockHistory)->toBeInstanceOf(UserBlockHistory::class);
    })->with('user_block_histories');

    it(
        'should deny creating user block history for locked and no ban duration',
        function (User& $user, UserBlockHistoryActionEnum $action, ?string $duration = null) {
            $this->expectException(InvalidUserBlockHistoryRecordException::class);

            $blockHistory = $this->userBlockHistoryRepository->addHistoryFrom($user, $action, $duration);

            expect($blockHistory)->toThrow(InvalidUserBlockHistoryRecordException::class);
            expect($blockHistory)->not()->toBeInstanceOf(UserBlockHistory::class);
        }
    )->with([
        [
            fn() => User::factory()->create(),
            UserBlockHistoryActionEnum::locked(),
            null
        ],
    ]);
});