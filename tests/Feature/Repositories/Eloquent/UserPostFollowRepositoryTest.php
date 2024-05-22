<?php

use App\Enums\PostStatus;
use App\Models\Posts\Category as PostsCategory;
use App\Models\Posts\Post;
use App\Models\User;
use App\Repositories\Eloquent\Posts\UserPostFollowRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('User Post Follow Repository', function () {
    beforeEach(function () {
        $this->userPostFollowRepository = new UserPostFollowRepository();
    });

    test('published post is followable', function (Post $post) {
        $isPostFollowable = $this->userPostFollowRepository->isPostFollowable($post, $post->user);

        expect($isPostFollowable)->toBeTrue();
    })->with('published-post');

    test('not-published post is not followable', function (Post $post) {
        $isPostFollowable = $this->userPostFollowRepository->isPostFollowable($post, $post->user);

        expect($isPostFollowable)->toBeFalse();
    })->with('unpublished-post');

    test('user can follow a post', function (User $user) {
        $this->actingAs($user);
        $post = Post::factory()
            ->for(PostsCategory::factory())
            ->create(['status' => PostStatus::Published]);

        $this->userPostFollowRepository->followPost($post, $user);

        expect($post->followers()->where('user_id', $user->getKey())->exists())->toBeTrue();
    })->with('custom-user');
});
