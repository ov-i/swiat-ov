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
    /**
     * Creates history record for currently banned user
     */
    public function addToHistory(CreateUserBlockHistoryData $data): ?UserBlockHistory
    {
        return $this->create([
            ...$data->toArray(),
            'operator_id' => auth()->id(),
        ]);
    }

    /**
     * Gets history records for referencd user with action type: Default locked()
     *
     * @param UserBlockHistoryActionEnum|null $action User blocked enum: default locked()
     * @param BanDurationEnum|null Optional flag getting a ban duration value
     *
     * @return int
     */
    public function historyRecordsCount(
        User &$user,
        UserBlockHistoryActionEnum $action = null,
        BanDurationEnum $banDurationEnum = null
    ): int {
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

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return UserBlockHistory::class;
    }
}
