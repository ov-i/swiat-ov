<?php

namespace App\Repositories\Eloquent\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserStatusEnum;
use App\Exceptions\AdminIsNotBlockableException;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Carbon;

class AuthRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param array<string, string>|RegisterRequestData $requestData
     * @return User|null
     */
    public function createUser(array|RegisterRequestData $requestData): ?User
    {
        /** @phpstan-ignore-next-line */
        return $this->create($requestData);
    }

    /**
     * Calculates the user's lock interval.
     *
     * @param User& $user Referenced user.
     *
     * @return string|null Returns null if user is NOT blocked.
     */
    public function blockedUntil(User &$user): ?string
    {
        if (false === $user->isBlocked()) {
            return null;
        }

        $createdAt = Carbon::parse($user->banned_at);
        $blockedUntil = $createdAt->add($user->ban_duration);

        return $blockedUntil->format('Y-m-d H:i:s');
    }

    /**
     * @throws AdminIsNotBlockableException
     */
    public function lockUser(User &$user, BanDurationEnum $duration): bool
    {
        // TODO: Move it to the actionable controller.
        if (true === $user->isAdmin()) {
            throw new AdminIsNotBlockableException($user);
        }

        return false === $user->isBlocked() && $user->update([
            'status' => UserStatusEnum::banned()->value,
            'ban_duration' => $duration->value,
            'banned_at' => now(),
        ]);
    }

    public function unlockUser(User &$user): bool
    {
        return $user->isBlocked() && $user->update([
            'status' => UserStatusEnum::active()->value,
            'ban_duration' => null,
            'banned_at' => null,
        ]);
    }
}
