<?php

namespace App\Livewire\Admin\Posts\Index;

use App\Enums\ItemsPerPageEnum;
use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{   
    use WithPagination;

    private PostService $postService;

    public function mount(
        PostService $postService,
    ): void {
        $this->authorize('view-posts', auth()->user());

        $this->postService = $postService;
    }

    public function render(): View
    {
        return view('livewire.admin.posts.index.table', [
            'posts' => Post::paginate(ItemsPerPageEnum::DEFAULT)
        ]);
    }

    public function placeholder(): View
    {
        return view('livewire.admin.posts.index.table-placeholder');
    }

    public function delete(Post $post): void
    {
        $this->authorizeResource($post);
        
        $this->postService->deletePost($post);
    }
}
