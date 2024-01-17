<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Follow;
use App\Models\Followable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CanFollow
{
    public function follows(): MorphMany
    {
        return $this->morphMany(Follow::class, 'follower');
    }

    public function follow(Followable $followable): void
    {
        if(false === $this->isFollowing($followable)) {
            $this->follows()->create(['followable' => $followable]);
        }
    }

    public function unfollow(Followable $followable): void
    {
        $this->follows()
            ->where('followable_id', $followable->getKey())
            ->where('followabl_type', get_class($followable))
            ->delete();
    }

    public function isFollowing(Followable $followable): bool
    {
        return $this->follows()
            ->where('followable_id', $followable->getKey())
            ->where('followable_type', get_class($followable))
            ->exists();
    }
}