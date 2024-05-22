<?php

namespace App\Models;

use App\Enums\AppTheme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppSettings extends Model
{
    use HasFactory;

    protected $table = 'user_app_settings';

    protected $fillable = [
        'theme'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function casts(): array
    {
        return [
            'theme' => AppTheme::class
        ];
    }

}
