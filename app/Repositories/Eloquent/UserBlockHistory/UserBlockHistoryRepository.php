<?php

namespace App\Repositories\Eloquent\UserBlockHistory;

use App\Data\Auth\CreateUserBlockHistoryRequestData;
use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\BaseRepository;

class UserBlockHistoryRepository extends BaseRepository
{
    public function __construct(
        UserBlockHistory $userBlock,
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

    /**
     * Adds history record for locked user based on user reference and duration.
     *
     * @param User& $user
     * @param BanDurationEnum|null $duration
     *
     * @return UserBlockHistory|null
     */
    public function addHistoryFrom(
        User &$user,
        UserBlockHistoryActionEnum $action,
        ?BanDurationEnum $duration = null,
    ): ?UserBlockHistory {
        return $this->addToHistory(
            CreateUserBlockHistoryRequestData::from([
                'user_id' => $user->id,
                'action' => $action->value,
                'ban_duration' => $duration->value ?? null,
            ])
        );
    }
}
