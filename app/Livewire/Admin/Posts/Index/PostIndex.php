<?php

namespace App\Livewire\Admin\Posts\Index;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PostIndex extends Component
{
    public Filters $filters;

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.posts.index.page');
    }
}
