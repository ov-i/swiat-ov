<?php

namespace App\Repositories\Eloquent\UserBlockHistory;

use App\Data\Auth\CreateUserBlockHistoryData;
use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class UserBlockHistoryRepository extends BaseRepository
{
    public function __construct(
        private readonly UserBlockHistory $userBlock,
    ) {
        parent::__construct($userBlock);
    }

    /**
     * Creates history record for currently banned user
     *
     * @param CreateUserBlockHistoryData $data
     *
     * @return UserBlockHistory|null
     */
    public function addToHistory($data)
    {
        return $this->create([
            ...$data->toArray(),
            'operator_id' => auth()->id(),
        ]);
    }

    /**
     * Gets history records for referencd user with action type: Default locked()
     *
     * @param User $user Referenced user
     * @param UserBlockHistoryActionEnum|null $action User blocked enum: default locked()
     * @param BanDurationEnum|null Optional flag getting a ban duration value
     *
     * @return int
     */
    public function historyRecordsCount(&$user, $action = null, $banDurationEnum = null)
    {
        if (null === $action) {
            $action = UserBlockHistoryActionEnum::locked();
        }

        $userBlockHistories = $this->findWhere(function (Builder $query) use (&$user, $action, $banDurationEnum) {
            $records = $query
                ->where('user_id', $user->getKey())
                ->where('action', $action->value);

            if (filled($banDurationEnum)) {
                $records->where('ban_duration', $banDurationEnum->value);
            }

            return $records;
        })->count();

        return $userBlockHistories;
    }
}
