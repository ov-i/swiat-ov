<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccountHistory extends Model
{
    protected $fillable = [
        'user_id',
        'action'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
