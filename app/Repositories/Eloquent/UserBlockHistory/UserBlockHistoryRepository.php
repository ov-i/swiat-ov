<?php

namespace App\Repositories\Eloquent\UserBlockHistory;

use App\Data\Auth\CreateUserBlockHistoryRequestData;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\BaseRepository;

class UserBlockHistoryRepository extends BaseRepository
{
    public function __construct(
        UserBlockHistory $userBlock
    ) {
        parent::__construct($userBlock);
    }

    /**
     * Creates history record for currently banned user
     *
     * @param CreateUserBlockHistoryRequestData $requestData
     *
     * @return UserBlockHistory|null
     */
    public function addToHistory(CreateUserBlockHistoryRequestData $requestData): ?UserBlockHistory
    {
        return $this->create($requestData);
    }
}
