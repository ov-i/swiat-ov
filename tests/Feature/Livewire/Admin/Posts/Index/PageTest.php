<?php

use App\Livewire\Admin\Posts\Index\PostIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('renders successfully', function (User $user) {
    Livewire::actingAs($user)
        ->test(PostIndex::class)
        ->assertStatus(200);
})->with('custom-user');
