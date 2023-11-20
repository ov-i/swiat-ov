<?php

namespace App\Models;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\RoleNamesEnum;
use App\Enums\Auth\UserStatusEnum;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use Database\Factories\UserFactory;
use App\Models\License\License;
use App\Models\Posts\Post;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $ip
 * @property UserStatusEnum|string $status
 * @property ?DateTime $last_login_at
 * @property ?DateTime $banned_at
 * @property ?BanDurationEnum $ban_duration
 */
class User extends Authenticatable implements CanUseTickets
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;
    use HasRoles;
    use HasTickets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ip',
        'status',
        'last_login_at',
        'banned_at',
        'ban_duration',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * @return HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return BelongsToMany<License>
     */
    public function licenses(): BelongsToMany
    {
        return $this->belongsToMany(License::class, 'license_user', 'license_id', 'user_id')->withTimestamps();
    }

    /**
     * @return HasMany<UserBlockHistory>
     */
    public function userBlockHistories(): HasMany
    {
        return $this->hasMany(UserBlockHistory::class, 'user_id', 'id');
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * @return string
     */
    public function guardName(): string
    {
        return 'web';
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RoleNamesEnum::admin()->value);
    }

    public function isModerator(): bool
    {
        return $this->hasRole(RoleNamesEnum::moderator()->value);
    }

    public function isBlocked(): bool
    {
        return UserStatusEnum::banned()->value === $this->status;
    }

    /**
     * Checks if user can be unlocked.
     *
     * @return bool Returns true, if user is blocked and duration is not permament.
     */
    public function canBeUnlocked(): bool
    {
        return
            $this->isBlocked() &&
            BanDurationEnum::forever()->value !== $this->ban_duration;
    }

    public function isActive(): bool
    {
        return UserStatusEnum::banned()->value === $this->status;
    }
}
