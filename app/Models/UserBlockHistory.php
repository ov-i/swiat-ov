<?php

namespace App\Models;

use Database\Factories\UserBlockHistoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBlockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'ban_duration'
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Factory<UserBlockHistoryFactory>
     */
    protected static function newFactory(): Factory
    {
        return UserBlockHistoryFactory::new();
    }
}
