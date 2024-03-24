<?php

namespace App\Models;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\RoleNamesEnum;
use App\Enums\Auth\UserStatusEnum;
use App\Observers\UserObserver;
use App\Traits\HasSettings;
use Database\Factories\UserFactory;
use App\Models\License\License;
use App\Models\Posts\Post;
use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $ip
 * @property ?DateTime $last_login_at
 * @property ?DateTime $banned_at
 * @property string $status
 * @property ?string $ban_duration
 */
#[ObservedBy([
    UserObserver::class
])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;
    use Searchable;
    use HasRoles;
    use SoftDeletes;
    use HasSettings;

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
        'lock_reason'
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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * @return list<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'string',
            'ban_duration' => 'string'
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getLastLoginTZ(): DateTime|string|null
    {
        return $this->last_login_at;
    }

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

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function accountHistories(): HasMany
    {
        return $this->hasMany(UserAccountHistory::class);
    }

    public function postHistories(): HasMany
    {
        return $this->hasMany(PostHistory::class);
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
        return $this->status === UserStatusEnum::banned()->value;
    }

    /**
     * Checks if user can be unlocked.
     *
     * @return bool Returns true, if user is blocked and duration is not permament.
     */
    public function canBeUnlocked(): bool
    {
        return
            ($this->isBlocked() && filled($this->ban_duration)) &&
            $this->ban_duration !== BanDurationEnum::forever()->value;
    }

    public function isPostAuthor(Post $post): bool
    {
        return $this->getKey() === $post->user()->getParentKey();
    }

    public function followedPosts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'followable', 'user_follows');
    }
}
