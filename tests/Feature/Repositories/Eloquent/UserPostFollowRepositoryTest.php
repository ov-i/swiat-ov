<?php

use App\Enums\PostStatus;
use App\Models\Posts\Category as PostsCategory;
use App\Models\Posts\Post;
use App\Models\User;
use App\Repositories\Eloquent\Posts\UserPostFollowRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

describe('User Post Follow Repository', function () {
    beforeEach(function () {
        $this->userPostFollowRepository = new UserPostFollowRepository();
    });

    test('published post is followable', function (Post $post, User $user) {
        actingAs($user);

        $isPostFollowable = $this->userPostFollowRepository->isPostFollowable($post, $user);

        expect($isPostFollowable)->toBeTrue();
    })->with('published-post', 'custom-user');

    test('not-published post is not followable', function (Post $post) {
        $isPostFollowable = $this->userPostFollowRepository->isPostFollowable($post, $post->user);

        expect($isPostFollowable)->toBeFalse();
    })->with('unpublished-post');

    test('user can follow a post', function (User $user, Post &$post) {
        actingAs($user);

        $this->userPostFollowRepository->followPost($post, $user);

        expect($post->fresh()->isFollowed($user))->toBeTrue();
    })->with('custom-user', 'published-post');
});
