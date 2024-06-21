<?php

use App\Livewire\Admin\Posts\Show\Relations\Tags;
use App\Models\Posts\Post;
use Livewire\Livewire;

it('renders successfully', function (Post $post) {
    Livewire::test(Tags::class)
        ->set('post', $post->fresh())
        ->assertStatus(200);
})->with('published-post');
