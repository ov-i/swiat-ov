<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

abstract class Followable extends Model
{
    public function followedBy(): MorphMany
    {
        return $this->morphMany(Follow::class, 'followable');
    }
}