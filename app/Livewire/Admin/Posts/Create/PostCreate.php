<?php

namespace App\Livewire\Admin\Posts\Create;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PostCreate extends Component
{
    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.posts.create.page');
    }
}
