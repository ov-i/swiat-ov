<?php

use App\Livewire\Admin\Posts\Index\Table;

test('renders successfully', function () {
    Livewire::test(Table::class)
        ->assertStatus(200);
});
