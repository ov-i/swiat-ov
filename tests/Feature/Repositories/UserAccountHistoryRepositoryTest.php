<?php

use App\Enums\User\UserAccountHistoryEnum;
use App\Models\User;
use App\Models\UserAccountHistory;
use App\Repositories\Eloquent\UserAccountHistory\UserAccountHistoryRepository;

describe('User Account History Repository', function () {
    beforeEach(function () {
        $this->userAccountHistoryRepository = new UserAccountHistoryRepository();
    });

    it('should be able to save history for user with action provided', function (
        User $user,
        UserAccountHistoryEnum $action
    ) {
        $history = $this->userAccountHistoryRepository->saveHistory($user, $action);

        expect($history)->toBeInstanceOf(UserAccountHistory::class);
    })->with('custom-user', UserAccountHistoryEnum::cases());
});
