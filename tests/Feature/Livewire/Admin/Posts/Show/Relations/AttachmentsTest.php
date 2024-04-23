<?php

use App\Livewire\Admin\Posts\Show\Relations\Attachments;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Attachments::class)
        ->assertStatus(200);
});
