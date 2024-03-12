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
        'ban_duration',
        'operator_id'
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function operator()
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
