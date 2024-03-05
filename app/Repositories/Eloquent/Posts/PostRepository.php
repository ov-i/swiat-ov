<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository
{
    public function __construct(
        private readonly Post $post,
    ) {
        parent::__construct($post);
    }

    /**
     * @param array<array-key, scalar> $postData
     */
    public function createPost(array $postData): Post
    {
        return $this->create([
            ...$postData,
            'user_id' => auth()->id(),
            'status' => PostStatusEnum::unpublished(),
            'slug' => Str::slug($postData['title']),
            'should_be_published_at' => $postData['publishable_date_time'] ?? null,
        ]);
    }

    public function editPost(Post &$post, array $postData): bool
    {
        return $post->update($postData);
    }

    public function setStatus(Post &$post, PostStatusEnum $status): self
    {
        if ($post->getStatus() === $status) {
            throw new \Exception(__("Post {$post->getTitle()} is already {$status->value}"));
        }

        $post->status = $status;

        switch($status) {
            case PostStatusEnum::published():
                $post->published_at = now();
                break;
            case PostStatusEnum::archived():
                $post->archived = true;
                $post->archived_at = true;
                break;
            default:
                break;
        }

        $post->update();

        return $this;
    }

    public function findPostViaTitle(string $title): ?Post
    {
        return $this->findBy('title', $title);
    }


    public function postExists(string $title): bool
    {
        $existingPost = $this->findPostViaTitle($title);

        return filled($existingPost);
    }

    public function updateThumbnailPath(string $path): bool
    {
        return $this->update(['thumbnail_path' => $path]);
    }

    public function deletePost(Post &$post, bool $forceDelete = false): bool
    {
        $deleted = $this->delete($post, $forceDelete);

        $this->setStatus($post, PostStatusEnum::inTrash());

        return $deleted;
    }

    /**
     * Tries to find any already published event or delayed and not published yet.
     */
    public function isAnyEventPublished(): bool
    {
        return $this->findWhere(params: function (Builder $query) {
            $query
                ->where('type', PostTypeEnum::event())
                ->where('status', PostStatusEnum::published())
                ->orWhere(function (Builder $builder) {
                    $builder
                        ->where('type', PostTypeEnum::event())
                        ->where('status', PostStatusEnum::delayed())
                        ->whereNotNull('should_be_published_at');
                });
        })->exists();
    }
}
