<?php

use App\Enums\PostStatus;
use App\Livewire\Admin\Posts\StatusUpdate;
use App\Models\Posts\Post;

use App\Models\User;

use function Pest\Laravel\actingAs;

describe('Status Update', function () {
    it('should render successfully', function () {
        Livewire::test(StatusUpdate::class)
            ->assertStatus(200);
    });

    it('should be able to update post status', function (User $user, Post $post) {
        actingAs($user);

        $status = PostStatus::Archived;

        $component = Livewire::test(StatusUpdate::class)
            ->set('post', $post)
            ->set('newStatus', $status)
            ->call('updateStatus');

        $component->assertOk();
    })->with('custom-user', 'unpublished-post');
});
