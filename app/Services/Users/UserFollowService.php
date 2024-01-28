<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Contracts\Followable;
use App\Exceptions\AlreadyFollowedEntity;
use App\Models\User;

class UserFollowService
{
    /**
     * Follow any followable entity for the user.
     *
     * @param User $user Which user should follow entity.
     * @param Followable $followable Entity that should be followed.
     *
     * @return bool Returns false if entity is already followed by user.
     */
    public function follow(User &$user, Followable $followable): bool
    {
        if (true === $this->alreadyFollowed($user, $followable)) {
            $followableType = $followable::class;
            throw new AlreadyFollowedEntity(
                "User [{$user->getName()}] is already following an entity {$followableType}::{$followable->getKey()}"
            );
        }

        $followable->followers()->attach($user->getKey());

        return true;
    }

    public function alreadyFollowed(User &$user, Followable $followable): bool
    {
        return $followable->followers()->wherePivot('user_id', $user->getKey())->exists();
    }
}
