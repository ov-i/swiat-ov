<?php

use App\Enums\Post\PostTypeEnum;
use App\Models\Posts\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

uses(WithFaker::class);

dataset('createPost', function () {
    return [
        [
            'user_id' => fn () => User::factory()->create(),
            'category_id' => fn () => Category::factory()->create(),
            'title' => fake()->unique()->sentence(),
            'type' => PostTypeEnum::post(),
            'content' => fake()->sentences(),
        ],
    ];
});
