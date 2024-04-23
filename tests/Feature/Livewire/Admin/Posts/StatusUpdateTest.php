<?php

use App\Enums\PostStatus;
use App\Livewire\StatusUpdate;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Status Update', function () {
    it('should render successfully', function (User $user, Post $post) {
        Livewire::actingAs($user)
            ->test(StatusUpdate::class)
            ->set('post', $post)
            ->assertStatus(200);
    })->with('custom-user', 'unpublished-post');

    it('should be able to update post status', function (User $user, Post $post) {
        $status = PostStatus::Archived;

        Livewire::actingAs($user)
            ->test(StatusUpdate::class)
            ->set('post', $post)
            ->set('newStatus', $status)
            ->call('updateStatus')
            ->assertSuccessful();
    })->with('custom-user', 'unpublished-post');
});
