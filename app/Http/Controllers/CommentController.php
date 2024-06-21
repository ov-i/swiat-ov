<?php

namespace App\Http\Controllers;

use App\Data\CommentData;
use App\Models\Posts\Comment;
use App\Models\Posts\Post;
use App\Services\Post\CommentService;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService,
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post, CommentData $commentData)
    {
        $this->authorize('create-comment');

        $comment = $this->commentService->createComment($post, $commentData);

        $afterCreationLink = $this->generateAfterCreationLink($comment);

        return redirect($afterCreationLink);
    }

    private function generateAfterCreationLink(Comment &$comment): string
    {
        return sprintf('/wpisy/%s/#comment-%s', $comment->post->toSlug(), $comment->getKey());
    }
}
