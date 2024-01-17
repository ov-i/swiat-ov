<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Enums\Post\PostStatusEnum;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\BaseRepository;

class PostRepository extends BaseRepository
{
    public function __construct(
        private readonly Post $post
    ) {
        parent::__construct($post);
    }

    /**
     * @param array<array-key, mixed> $postData
     */
    public function createPost(array $postData): Post
    {
        return $this->create($postData);
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

        $post->update();

        return $this;
    }

    public function findPostViaTitle(string $title): ?Post
    {
        return $this->getModel()->query()
            ->where('title', $title)
            ->first();
    }
}
