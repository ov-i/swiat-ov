<?php

namespace App\Repositories\Eloquent\Posts;

use App\Models\Posts\Comment;
use App\Repositories\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository
{
    /**
    * @inheritDoc
    */
    protected static function getModelFqcn()
    {
        return Comment::class;
    }
}
