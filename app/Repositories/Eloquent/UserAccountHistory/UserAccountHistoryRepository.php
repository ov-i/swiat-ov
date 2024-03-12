<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\UserAccountHistory;

use App\Enums\User\UserAccountHistoryEnum;
use App\Models\User;
use App\Models\UserAccountHistory;
use App\Repositories\Eloquent\BaseRepository;

class UserAccountHistoryRepository extends BaseRepository
{
    public function __construct(
        UserAccountHistory $accountHistory
    ) {
        parent::__construct($accountHistory);
    }

    /**
     * Saves history from user details with an action type.
     *
     * @param User &$user Referenced user
     * @param UserAccountHistoryEnum $action
     *
     * @return UserAccountHistory|null
     */
    public function saveHistory(User &$user, UserAccountHistoryEnum $action): ?UserAccountHistory
    {
        return $this->create([
            'user_id' => $user->getKey(),
            'action' => $action->value,
        ]);
    }
}
