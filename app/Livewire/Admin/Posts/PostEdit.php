<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class PostEdit extends Component
{
    #[Locked, Url]
    public Post $post;

    #[Locked]
    public array $postTypes;

    public function mount(): void
    {
        $this->post = request('post');
    }

    public function render(
        PostRepository $postRepository,
    ): View {
        return view('livewire.admin.posts.post-edit');
    }
}
