<?php

use App\Models\Posts\Post;

dataset('unpublished-post', function () {
    return [fn () => Post::factory()->unpublished()->create()];
});
