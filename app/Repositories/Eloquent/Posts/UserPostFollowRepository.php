<?php

namespace App\Repositories\Eloquent\Posts;

use App\Models\Posts\Post;
use App\Models\Posts\UserPostFollow;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;

class UserPostFollowRepository extends BaseRepository
{
    public function isPostFollowable(Post &$post, User &$user): bool
    {
        return $post->isPublished() && !$post->followers()
            ->where('user_id', $user->getKey())
            ->exists();
    }

    public function followPost(Post &$post, User &$user): void
    {
        if (!$this->isPostFollowable($post, $user)) {
            return;
        }

        $post->followers()->attach($user->getKey());
    }

    /**
    * @inheritDoc
    */
    protected static function getModelFqcn()
    {
        return UserPostFollow::class;
    }
}
