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
        return
            $post->isPublished() &&
            !$user->isPostAuthor($post) &&
            !$post->isFollowed($user);
    }

    public function followPost(Post &$post, User &$user): bool
    {
        if (!$this->isPostFollowable($post, $user)) {
            return false;
        }

        $post->followers()->attach($user->getKey());

        return true;
    }

    public function unfollowPost(Post &$post, User &$user): bool
    {
        if (!$post->isFollowed($user)) {
            return false;
        }

        return $post->followers()->detach($user->getKey());
    }

    /**
    * @inheritDoc
    */
    protected static function getModelFqcn()
    {
        return UserPostFollow::class;
    }
}
