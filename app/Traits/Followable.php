<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Followable
{
    public function followers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'followable', 'user_follows')->withTimestamps();
    }
}