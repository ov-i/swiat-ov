<?php

namespace App\Repositories\Eloquent\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserStatusEnum;
use App\Exceptions\AdminIsNotBlockableException;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Model;
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
    public function createUser(array|RegisterRequestData $requestData): ?Model
    {
        /** @phpstan-ignore-next-line */
        return $this->create($requestData);
    }

    public function isUserBlocked(User $user): bool
    {
        return UserStatusEnum::banned()->value === $user->status;
    }

    public function isUserActive(User $user): bool
    {
        return UserStatusEnum::active()->value === $user->status;
    }

    public function blockedUntil(User $user): ?string
    {
        if (false === $user->isBlocked()) {
            return null;
        }

        if (BanDurationEnum::forever()->value === $user->ban_duration) {
            return null;
        }

        $createdAt = Carbon::parse($user->banned_at);
        $blockedUntil = $createdAt->add($user->ban_duration);

        return $blockedUntil->isPast() ? null : $blockedUntil->format('Y-m-d H:i:s');
    }

    /**
     * @throws AdminIsNotBlockableException
     */
    public function lockUser(User $user, BanDurationEnum $duration): bool
    {
        if (true === $user->isAdmin()) {
            throw new AdminIsNotBlockableException($user);
        }

        return false === $user->isBlocked() && $user->update([
            'status' => UserStatusEnum::banned()->value,
            'ban_duration' => $duration->value,
            'banned_at' => now(),
        ]);
    }

    public function unlockUser(User $user): bool
    {
        return $user->isBlocked() && $user->update([
            'status' => UserStatusEnum::active()->value,
            'ban_duration' => null,
            'banned_at' => null,
        ]);
    }

    public function isBanDurationOver(User $user): bool
    {
        return
            $user->isBlocked() &&
            BanDurationEnum::forever()->value !== $user->ban_duration &&
            null === $this->blockedUntil($user);
    }
}
