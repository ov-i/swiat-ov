<?php

use App\Models\Posts\Category;
use App\Models\Posts\Post;

dataset('trashed-post', function () {
    return [fn () => Post::factory()->for(Category::factory())->trashed()->create()];
});
