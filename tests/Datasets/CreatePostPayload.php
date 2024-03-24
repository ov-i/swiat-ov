<?php

use App\Enums\Post\PostTypeEnum;
use Illuminate\Foundation\Testing\WithFaker;

dataset('create-post-payload', function () {
    uses(WithFaker::class);

    return [[[
        'category_id' => 1,
        'title' => fake()->realText(40),
        'type' => PostTypeEnum::post(),
        'content' => fake()->realText(),
    ]]];
});
