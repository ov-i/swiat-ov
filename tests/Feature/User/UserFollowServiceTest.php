<?php

use App\Models\Posts\Post;
use App\Models\User;
use App\Services\Users\UserFollowService;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe('User Follow Service test', function () {
    beforeEach(function () {
        uses(RefreshDatabase::class);

        $this->userFollowService = new UserFollowService();
    });

    test('user should be able to follow post', function () {
        $this->actingAs($user = User::factory()->dummy()->create());

        $post = Post::factory()->create();

        $followed = $this->userFollowService->follow($user, $post);
        expect($followed)->toBeTrue();
    });
});
