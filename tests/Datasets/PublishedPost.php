<?php

use App\Enums\PostStatus;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;

dataset('published-post', function () {
    return [
        fn () => Post::factory()
            ->for(Category::factory())
            ->for(User::factory())
            ->create(['status' => PostStatus::Published])
    ];
});
