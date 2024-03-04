<?php

namespace App\Models\Posts;

use App\Contracts\Followable;
use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
use App\Models\PostHistory;
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
use Laravel\Scout\Searchable;
use Stringable;

class Post extends Model implements Followable, Stringable
{
    use SoftDeletes;
    use HasFactory;
    use \App\Traits\Followable;
    use Searchable;

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
        'should_be_published_at',
        'excerpt'
    ];

    public function __toString(): string
    {
        return sprintf('[%s] %s', $this->getStatus(), $this->getTitle());
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getThumbnailPath(): ?string
    {
        return $this->thumbnail_url;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function getArchivedAt(): ?Date
    {
        if (false === $this->isArchived()) {
            return null;
        }

        /** @var ?Date $archivedAt */
        $archivedAt = $this->archived_at;

        return $archivedAt;
    }

    public function getPublishedAt(): ?DateTime
    {
        return $this->published_at;
    }

    public function getPublishableDate(): ?string
    {
        return $this->should_be_published_at;
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

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }

    public function isPublished(): bool
    {
        return $this->getStatus() === PostStatusEnum::published();
    }

    public function isClosed(): bool
    {
        return $this->getStatus() === PostStatusEnum::closed();
    }

    public function isEvent(): bool
    {
        return $this->type === PostTypeEnum::event()->value;
    }

    public function isDelayed(): bool
    {
        return null !== $this->getPublishableDate();
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
