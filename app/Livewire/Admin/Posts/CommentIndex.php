<?php

namespace App\Livewire\Admin\Posts;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CommentIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.posts.comment-index');
    }
}
