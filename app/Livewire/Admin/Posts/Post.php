<?php

namespace App\Livewire\Admin\Posts;

use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Post extends Component
{
    use WithPagination;

    public ?int $perPage = null;

    public string $search = '';

    private PostRepository $postRepository;

    private PostService $postService;

    public function boot(
        PostRepository $postRepository,
        PostService $postService,
    ): void {
        $this->postRepository = $postRepository;
        $this->postService = $postService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        $posts = $this->postRepository->all(perPage: $this->perPage);

        if (filled($this->search)) {
            $posts = $this->postRepository->searchBy(strtolower($this->search));
        }

        return view('livewire.admin.posts.post', ['posts' => $posts]);
    }

    public function delete(int $postId): void
    {
        $post = $this->postRepository->find($postId);
        $this->authorize('delete', [$post]);

        $this->postService->deletePost($post);
    }

    public function forceDelete(int $postId): void
    {
        $post = $this->postRepository->find($postId);
        $this->authorize('forceDelete', [auth()->user()]);

        $this->postService->deletePost($post, forceDelete: true);
    }
}
