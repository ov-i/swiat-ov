<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Data\PostData;
use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository
{
    /**
     * @param non-empty-list<array-key, scalar> $postData
     */
    public function createPost(PostData $postForm): Post|false
    {
        if($this->postExists($postForm->title)) {
            return false;
        }

        return $this->create([
            ...$postForm->toArray(),
            'slug' => str($postForm->title)->slug(),
            'should_be_published_at' => $postForm->should_be_published_at,
            'user_id' => auth()->id(),
        ]);
    }

    public function editPost(Post &$post, array $requestData): bool
    {
        $titleModified = $post->getTitle() !== $requestData['title'];
        if (($titleModified && $this->postExists($requestData['title'])) || $post->isClosed()) {
            return false;
        }

        return $this->update(model: $post, data: $requestData);
    }

    public function setStatus(Post &$post, PostStatus $status): self
    {
        if ($status === $post->getStatus()) {
            throw new \LogicException(__("Post {$post->getTitle()} is already {$status->label()}"));
        }

        $post->status = $status;

        if (!$this->bindPostStatusToValue($post, $status)) {
            throw new \RuntimeException("Something went wrong during updating status");
        }

        return $this;
    }

    public function findPostViaTitle(string $title): ?Post
    {
        return $this->findBy('title', $title);
    }

    public function postExists(string $title): bool
    {
        $post = $this->findPostViaTitle($title);

        return filled($post) || $this->isTitleDuplicated($title);
    }

    public function updateThumbnailPath(Post &$post, string $path): bool
    {
        return $this->update($post, ['thumbnail_path' => $path]);
    }

    public function deletePost(Post &$post, bool $forceDelete = false): bool
    {
        $deleted = $this->delete($post, $forceDelete);

        $this->setStatus($post, PostStatus::InTrash);

        return $deleted;
    }

    public function restorePost(Post &$post): bool
    {
        return $post->restore();
    }

    /**
     * Tries to find any already published event or delayed and not published yet.
     */
    public function isAnyEventPublished(): bool
    {
        return $this->findWhere(params: function (Builder $query) {
            $query
                ->where('type', PostType::Event)
                ->where('status', PostStatus::Published)
                ->orWhere(function (Builder $builder) {
                    $builder
                        ->where('type', PostType::Event)
                        ->where('status', PostStatus::Delayed)
                        ->whereNotNull('should_be_published_at');
                });
        })->exists();
    }

    /**
     * Binds current post status with it's timestamps / boolean values
     */
    private function bindPostStatusToValue(Post &$post, PostStatus $status): bool
    {
        switch($status) {
            case PostStatus::Published:
                $post->published_at = now();
                break;
            case PostStatus::Archived:
                $post->archived = true;
                $post->archived_at = now()->toDateTime();
                break;
        }

        return $this->updateDirty($post);
    }

    /**
     * Checks if title exists by converting it to sluggable.
     */
    private function isTitleDuplicated(string $requestTitle): bool
    {
        $slug = $this->findBy('slug', Str::slug($requestTitle));

        return filled($slug);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return Post::class;
    }
}
