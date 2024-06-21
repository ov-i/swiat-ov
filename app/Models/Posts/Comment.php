<?php

namespace App\Models\Posts;

use App\Enums\Post\CommentStatus;
use Database\Factories\Posts\CommentFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'status'
    ];

    public function __toString(): string
    {
        return "Comment #{$this->getKey()}";
    }

    /** @return array<string, class-string<\BackedEnum> */
    protected function casts(): array
    {
        return [
            'status' => CommentStatus::class
        ];
    }

    /**
     * @return BelongsTo<Post, self>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return CommentFactory::new();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): ?CommentStatus
    {
        return $this->status;
    }

    public function isAccepted(): bool
    {
        return $this->getStatus() === CommentStatus::Accepted;
    }

    public function isInReview(): bool
    {
        return $this->getStatus() === CommentStatus::InReview;
    }

    public function isInTrash(): bool
    {
        return $this->getStatus() === CommentStatus::InTrash;
    }

    public function isArchived(): bool
    {
        return $this->getStatus() === CommentStatus::Accepted;
    }
}
