<?php

namespace App\Repositories\Eloquent\Posts;

use App\Data\CommentData;
use App\Models\Posts\Comment;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function createComment(Post &$post, CommentData $commentData): Comment
    {
        return $this->create([
            'user_id' => auth()->id(),
            'post_id' => $post->getKey(),
            ...$commentData->toArray()
        ]);
    }

    /**
    * @inheritDoc
    */
    protected static function getModelFqcn()
    {
        return Comment::class;
    }
}
