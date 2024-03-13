<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\UserAccountHistory;

use App\Enums\User\UserAccountHistoryEnum;
use App\Models\User;
use App\Models\UserAccountHistory;
use App\Repositories\Eloquent\BaseRepository;

class UserAccountHistoryRepository extends BaseRepository
{
    /**
     * Saves history from user details with an action type.
     */
    public function saveHistory(User &$user, UserAccountHistoryEnum $action): ?UserAccountHistory
    {
        return $this->create([
            'user_id' => $user->getKey(),
            'action' => $action->value,
        ]);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return UserAccountHistory::class;
    }
}
