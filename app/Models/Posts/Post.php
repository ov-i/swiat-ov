<?php

namespace App\Models\Posts;

use App\Contracts\Followable;
use App\Contracts\Sluggable;
use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\PostHistory;
use App\Traits\HasCommentsPolicy;
use App\Traits\HasLikes;
use Database\Factories\Posts\PostFactory;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Post extends Model implements Followable, Sluggable
{
    use SoftDeletes;
    use HasFactory;
    use \App\Traits\Followable;
    use Searchable;
    use HasLikes;
    use HasCommentsPolicy;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'type',
        'thumbnail_path',
        'content',
        'status',
        'archived',
        'archived_at',
        'published_at',
        'scheduled_publish_date',
        'excerpt'
    ];

    public function __toString(): string
    {
        return sprintf('[%s] %s', ucfirst($this->getStatus()->label()), $this->getTitle());
    }

    /**
     * @return non-empty-list<array-key, string>
     */
    protected function casts(): array
    {
        return [
            'type' => PostType::class,
            'status' => PostStatus::class
        ];
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }

    public function toSlug(): string
    {
        return Str::slug($this->getTitle());
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getType(): PostType
    {
        return $this->type;
    }

    public function getStatus(): ?PostStatus
    {
        return $this->status;
    }

    public function getThumbnailPath(): ?string
    {
        return $this->thumbnail_path;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function getArchivedAt()
    {
        if (!$this->isArchived()) {
            return null;
        }

        return $this->archived_at;
    }

    public function getPublishedAt(): ?DateTime
    {
        return $this->published_at;
    }

    public function getScheduledAt(): ?string
    {
        return $this->scheduled_publish_date;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

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
     * @return BelongsToMany<Attachment>
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class)->withTimestamps();
    }

    public function postHistories(): HasMany
    {
        return $this->hasMany(PostHistory::class);
    }

    /**
     * @return HasMany<LangPost>
     */
    public function langPost(): HasMany
    {
        return $this->hasMany(LangPost::class);
    }

    public function isPublished(): bool
    {
        return $this->getStatus() === PostStatus::Published;
    }

    public function isVipOnly(): bool
    {
        return $this->getType() === PostType::Vip;
    }

    public function isClosed(): bool
    {
        return $this->getStatus() === PostStatus::Closed;
    }

    public function isEvent(): bool
    {
        return $this->type === PostType::Event;
    }

    public function isScheduled(): bool
    {
        return filled($this->getScheduledAt());
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'type' => $this->getType(),
            'status' => $this->getStatus(),
            'user' => $this->user()->first(),
            'category' => $this->category()->first()
        ];
    }
}
