<?php

use App\Livewire\Admin\Posts\Index\Table;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('renders successfully', function (User $user) {
    Livewire::actingAs($user)
        ->test(Table::class)
        ->assertStatus(200);
})->with('custom-user');

test('denies enter for unauthorized user', function () {
    Livewire::test(Table::class)
        ->assertForbidden();
});

test('can delete post', function (Post &$post) {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Table::class)
        ->call('delete', $post)
        ->assertSuccessful();

    expect($post->fresh()->trashed())->toBeTrue();
})->with('unpublished-post');

test('user cannot delete not owned post', function () {
    $user = User::factory()->create();
    $stranger = User::factory()->dummy()->create();

    $post = Post::factory()
        ->for(Category::factory())
        ->for($stranger)
        ->create();

    Livewire::actingAs($user)
        ->test(Table::class)
        ->call('delete', $post)
        ->assertForbidden();
});

test('deletes selected posts', function (User &$user, array $ids) {
    Post::factory()
        ->for(Category::factory())
        ->unpublished()
        ->count(count($ids))
        ->create();

    Livewire::actingAs($user)
        ->test(Table::class)
        ->set('selectedItemIds', [...$ids])
        ->call('deleteSelected')
        ->assertSuccessful();
})->with('custom-user', [
    [[1, 2, 3]]
]);

test('restores softly deleted post', function (User $user, Post $post) {
    Livewire::actingAs($user)
        ->test(Table::class)
        ->call('restore', $post)
        ->assertSuccessful();

    expect($post->fresh()->trashed())->toBeFalse();
})->with('custom-user', 'trashed-post');
