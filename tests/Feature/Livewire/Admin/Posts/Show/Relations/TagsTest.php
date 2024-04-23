<?php

use App\Livewire\Admin\Posts\Show\Relations\Tags;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $post = Post::factory()->for(Category::factory())->for(User::factory())->create();
    Livewire::test(Tags::class)
        ->set('post', $post->fresh())
        ->assertStatus(200);
});
