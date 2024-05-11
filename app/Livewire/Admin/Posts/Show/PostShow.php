<?php

namespace App\Livewire\Admin\Posts\Show;

use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PostShow extends Component
{
    public Post $post;

    private PostService $postService;

    public function mount(): void
    {
        $this->authorize('view-post', $this->post);
    }

    public function boot(
        PostService $postService,
    ): void {
        $this->postService = $postService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.posts.show.post-show');
    }

    #[Computed]
    public function post(): Post
    {
        return $this->post;
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $this->postService->deletePost($post);
    }

    public function restore(Post $post)
    {
        $this->authorize('restore', $post);

        $this->postService->restorePost($post);
    }
}
