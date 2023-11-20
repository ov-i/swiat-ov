<?php

namespace App\Repositories\Eloquent\UserBlockHistory;

use App\Data\Auth\CreateUserBlockHistoryRequestData;
use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Enums\ItemsPerPageEnum;
use App\Exceptions\InvalidUserBlockHistoryRecordException;
use App\Models\User;
use App\Models\UserBlockHistory;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserBlockHistoryRepository extends BaseRepository
{
    public function __construct(
        UserBlockHistory $userBlock,
    ) {
        parent::__construct($userBlock);
    }

    /**
     * Gets paginated history records for referenced user with action type [default: locked]
     *
     * @param User& $user Referenced user
     * @param UserBlockHistoryActionEnum|null $action If it's stays nullable then default is locked() value
     *
     * @return LengthAwarePaginator|null Returns null if there were not any records in user block histories
     */
    public function getBlockHistoryPaginatedRecords(
        User &$user,
        ?UserBlockHistoryActionEnum $action = null
    ): ?LengthAwarePaginator {
        if (null === $action) {
            $action = UserBlockHistoryActionEnum::locked();
        }

        $userBlockHistories = $this->getModel()
            ->query()
            ->where(['user_id' => $user->id, 'action' => $action->value])
            ->orderBy('created_at')
            ->paginate(ItemsPerPageEnum::DEFAULT);

        if (true === $userBlockHistories->isEmpty()) {
            return null;
        }

        return $userBlockHistories;
    }

    /**
     * Gets history records for referencd user with action type: Default locked()
     *
     * @param User& $user Referenced user
     * @param UserBlockHistoryActionEnum|null $action User blocked enum: default locked()
     * @param BanDurationEnum|null Optional flag getting a ban duration value
     *
     * @return Collection<int, UserBlockHistory>|null Returns null if the is no matching records
     */
    public function getBlockHistoryRecords(
        User &$user,
        ?UserBlockHistoryActionEnum $action = null,
        ?BanDurationEnum $banDurationEnum = null,
    ): ?Collection {
        if (null === $action) {
            $action = UserBlockHistoryActionEnum::locked();
        }

        $userBlockHistories = $this->getModel()
            ->query()
            ->orderBy('id')
            ->where(['user_id' => $user->id, 'action' => $action->value]);

        if (null !== $banDurationEnum) {
            $userBlockHistories->where('ban_duration', $banDurationEnum->value);
        }

        if (count($userBlockHistories->get()) === 0) {
            return null;
        }

        return $userBlockHistories->get();
    }

    public function getCount(
        User &$user,
        ?UserBlockHistoryActionEnum $action,
        ?BanDurationEnum $duration = null
    ): int {
        $historyRecords = $this->getBlockHistoryRecords($user, $action, $duration);
        if (null === $historyRecords) {
            return 0;
        }

        return $historyRecords->count();
    }

    /**
     * Adds history record for locked user based on user reference and duration.
     */
    public function addHistoryFrom(
        User &$user,
        UserBlockHistoryActionEnum $action,
        ?BanDurationEnum $duration = null,
    ): ?UserBlockHistory {
        $this->denyIfLockedWithoutDuration($action, $duration);

        return $this->addToHistory(
            CreateUserBlockHistoryRequestData::from([
                'user_id' => $user->id,
                'action' => $action->value,
                'ban_duration' => $duration->value ?? null,
            ])
        );
    }

    public function denyIfLockedWithoutDuration(
        UserBlockHistoryActionEnum $action,
        ?BanDurationEnum $duration = null,
    ): void {
        if (UserBlockHistoryActionEnum::locked() === $action && null === $duration) {
            throw new InvalidUserBlockHistoryRecordException(__('auth.invalid_block_history_record'));
        }
    }

    /**
     * Creates history record for currently banned user
     *
     * @param CreateUserBlockHistoryRequestData $requestData
     *
     * @return UserBlockHistory|null
     */
    private function addToHistory(CreateUserBlockHistoryRequestData $requestData): ?UserBlockHistory
    {
        return $this->create($requestData);
    }
}
