<?php

use App\Enums\PostType;
use Illuminate\Foundation\Testing\WithFaker;

dataset('create-post-payload', function () {
    uses(WithFaker::class);

    return [[[
        'category_id' => 1,
        'title' => fake()->realText(40),
        'type' => PostType::Post,
        'content' => fake()->realText(),
    ]]];
});
