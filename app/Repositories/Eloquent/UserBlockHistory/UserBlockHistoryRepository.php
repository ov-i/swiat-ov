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
        return $this->create($data);
    }

    /**
     * Gets history records for referencd user. If no action and / or ban duration is specified,
     * returns count of all histories attached to the user.
     *
     * @return int
     */
    public function historyRecordsCount(
        User &$user,
        UserBlockHistoryActionEnum $action = null,
        ?BanDurationEnum $banDurationEnum = null
    ): int {
        if ((filled($action) && $action === UserBlockHistoryActionEnum::unlocked()) && filled($banDurationEnum)) {
            throw new \LogicException(__('Cannot declare unlocked history record with ban duration specified.'));
        }

        $userBlockHistories = $this->findWhere(function (Builder $query) use (&$user, $action, $banDurationEnum) {
            $records = $query
                ->where('user_id', $user->getKey());

            if (filled($action)) {
                $records->where('action', $action->value);
            }

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
