<?php

namespace App\Livewire\Admin\Posts\Edit;

use App\Models\Posts\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class PostEdit extends Component
{
    #[Modelable]
    public Post $post;

    public function mount(): void
    {
        abort_if(blank($this->post) || $this->post->isClosed(), Response::HTTP_NOT_FOUND);
    }


    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.posts.edit.page');
    }
}
