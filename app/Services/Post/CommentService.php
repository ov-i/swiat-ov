<?php

namespace App\Services\Post;

use App\Data\CommentData;
use App\Enums\Post\CommentStatus;
use App\Models\Posts\Comment;
use App\Models\Posts\Post;
use App\Models\User;
use App\Repositories\Eloquent\Posts\CommentRepository;
use App\Services\Service;
use Illuminate\Support\Facades\Gate;

class CommentService extends Service
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
    ) {
    }

    public function createComment(Post &$post, CommentData $commentData): ?Comment
    {
        /** @var User $user */
        $user = $this->getUser();

        if (Gate::allows('viewAdmin') || $user->isPostAuthor($post)) {
            $commentData->status = CommentStatus::Accepted;
        }

        // Add in-application notification system here ..
        $comment = $this->commentRepository->createComment($post, $commentData);

        return $comment;
    }
}
