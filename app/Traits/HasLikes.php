<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasLikes
{
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_likes');
    }
}
