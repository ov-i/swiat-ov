<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Enums\Post\PostHistoryActionEnum;
use App\Models\PostHistory;
use App\Models\Posts\Post;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class PostHistoryRepository extends BaseRepository
{
    public function addHistory(Post &$post, PostHistoryActionEnum $action): PostHistory
    {
        $user = $post->user();

        if (blank($user)) {
            throw new \LogicException("The post [{$post->getKey()}] is not being assigned to user");
        }

        return $this->create([
            'post_id' => $post->getKey(),
            'user_id' => $user->getParentKey(),
            'action' => $action
        ]);
    }

    /**
     * @return Collection<PostHistory>|null
     */
    public function findByUser(User &$user): ?Collection
    {
        return $this->findAllBy('user_id', $user->getKey());
    }

    /**
     * @return Collection<PostHistory>|null
     */
    public function findByAction(PostHistoryActionEnum $action): ?Collection
    {
        return $this->findAllBy('action', $action->value);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return PostHistory::class;
    }
}
