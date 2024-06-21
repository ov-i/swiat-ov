<?php

use App\Data\CommentData;
use App\Enums\Post\CommentStatus;
use App\Models\Posts\Comment;
use App\Models\Posts\Post;
use App\Models\User;
use App\Repositories\Eloquent\Posts\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

describe('Comment Repository', function () {
    beforeEach(function () {
        $this->commentRepository = new CommentRepository();
    });

    test('only logged in user should be able to create post', function (User &$user, Post &$post) {
        actingAs($user);

        $commentData = new CommentData(
            content: 'bar baz',
            status: CommentStatus::InReview,
        );

        /** @var Comment $comment */
        $comment = $this->commentRepository->createComment($post, $commentData);

        expect($comment->getKey())->not()->toBeNull();
        expect($comment->getContent())->not()->toBeNull();
        expect($comment->getStatus())->toBe(CommentStatus::InReview);
    })->with('custom-user', 'published-post');
});
