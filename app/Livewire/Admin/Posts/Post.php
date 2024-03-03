<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Post extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.posts');
    }
}
