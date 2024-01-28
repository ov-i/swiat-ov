<?php

use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use App\Services\Users\UserFollowService;

describe('User Follow Service test', function () {
    beforeEach(function () {
        $this->userFollowService = new UserFollowService();
    });

    test('user should be able to follow post', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->getKey(), 'category_id' => $category->getKey()]);

        $this->actingAs($user);

        $followed = $this->userFollowService->follow($user, $post);
        expect($followed)->toBeTrue();
    });
});
