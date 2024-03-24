<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Contracts\Filterable;
use App\Livewire\SearchableComponent;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Post extends SearchableComponent implements Filterable
{
    use WithPagination;

    protected $repository = PostRepository::class;

    private PostService $postService;

    public function boot(
        PostService $postService,
    ): void {
        $this->postService = $postService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        $posts = $this->search();

        return view('livewire.admin.posts.post', ['posts' => $posts]);
    }

    public function delete(int $postId): void
    {
        $post = $this->postRepository->find($postId);
        $this->authorize('delete', [$post]);

        $this->postService->deletePost($post);
    }

    /**
     * @inheritDoc
     */
    public function filters(): array
    {
        return [];
    }
}
