<?php

namespace App\Services\Users;
use App\Data\Auth\CreateUserBlockHistoryData;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Exceptions\InvalidUserBlockHistoryRecordException;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;

class UserBlockHistoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly UserBlockHistoryRepository $userBlockHistoryRepository,
    ) {
    }

    public function addToHistory(CreateUserBlockHistoryData $data): ?UserBlockHistory
    {
        if ($data->action === UserBlockHistoryActionEnum::locked() && blank($data->banDuration)) {
            throw new InvalidUserBlockHistoryRecordException(__('auth.invalid_block_history_record'));
        }

        return $this->userBlockHistoryRepository->addToHistory($data->toArray());
    }
}
