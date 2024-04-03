<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Contracts\Filterable;
use App\Livewire\SearchableResource;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\PostService;

class Post extends SearchableResource implements Filterable
{
    protected $repository = PostRepository::class;

    private PostService $postService;

    public function boot(
        PostService $postService,
    ): void {
        $this->postService = $postService;
    }

    public function mount(): void
    {
        $this->authorize('view-posts', auth()->user());
    }

    public function delete(int $postId): void
    {
        $post = $this->repository->find($postId);
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

    protected function getView(): string
    {
        return 'posts.post';
    }
}
