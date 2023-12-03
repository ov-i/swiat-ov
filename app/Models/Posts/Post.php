<?php

namespace App\Models\Posts;

use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
use Database\Factories\Posts\PostFactory;
use App\Models\User;
use Date;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user_id
 * @property int $category_id
 * @property string $title
 * @property PostTypeEnum $type
 * @property string $thumbnail_url
 * @property string $content
 * @property PostStatusEnum $status
 * @property bool $archived Default: false
 * @property Date $archived_at
 * @property DateTime $published_at
 */
class Post extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'type',
        'thumbnail_path',
        'content',
        'status',
        'archived',
        'archived_at',
        'published_at'
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Category, self>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return BelongsToMany<Tag>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * @return HasMany<Attachment>
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * @return HasMany<LangPost>
     */
    public function langPost(): HasMany
    {
        return $this->hasMany(LangPost::class);
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }

    public function isPublished(): bool
    {
        return $this->status === PostStatusEnum::published();
    }
}
