<?php

namespace App\Livewire\Admin\Posts\Index;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Page extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.posts.index.page');
    }
}
