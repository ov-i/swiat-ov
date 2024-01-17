<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'followable_id',
        'followable_type',
        'follower_id',
        'followable_type'
    ];

    public function followable(): MorphTo
    {
        return $this->morphTo();
    }

    public function follower(): MorphTo
    {
        return $this->morphTo();
    }
}