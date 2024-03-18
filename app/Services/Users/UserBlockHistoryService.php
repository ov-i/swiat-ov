<?php

namespace App\Services\Users;

use App\Data\Auth\CreateUserBlockHistoryData;

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
        return $this->userBlockHistoryRepository->addToHistory($data);
    }
}
