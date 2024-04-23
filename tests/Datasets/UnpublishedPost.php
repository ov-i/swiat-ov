<?php

use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;

dataset('unpublished-post', function () {
    return [
        fn () => Post::factory()
            ->for(Category::factory())
            ->for(User::factory())
            ->unpublished()
            ->create()
    ];
});
