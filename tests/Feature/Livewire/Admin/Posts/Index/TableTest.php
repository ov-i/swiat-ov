<?php

use App\Livewire\Admin\Posts\Index\Table;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

test('renders successfully', function() {
    Livewire::test(Table::class)
        ->assertStatus(200);
});


