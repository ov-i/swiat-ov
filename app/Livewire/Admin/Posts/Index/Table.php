<?php

namespace App\Livewire\Admin\Posts\Index;

use App\Enums\ItemsPerPageEnum;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Selectable;
use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    use Searchable;

    use Selectable;

    private PostService $postService;

    public function boot(
        PostService $postService,
    ): void {
        $this->authorize('view-posts', auth()->user())->asNotFound();

        $this->postService = $postService;
    }

    public function render(): View
    {
        $posts = Post::query();

        $posts = $this->applySearch($posts);
        
        $posts = $posts->paginate(ItemsPerPageEnum::DEFAULT);
        
        $this->itemIdsOnPage = collect($posts->items())
            ->map(fn (Post $post) => (string) $post->getKey())
            ->toArray();

        return view('livewire.admin.posts.index.table', [
            'posts' => $posts,
        ]);
    }

    public function applySearch(Builder &$builder): Builder|ScoutBuilder
    {
        if (filled($this->search)) {
            return Post::search($this->search);
        }

        return $builder;
    }

    public function delete(Post $post): void
    {
        $this->authorize('delete-post', $post)->asNotFound(); // anti bots scan

        $this->postService->deletePost($post);
    }

    public function deleteSelected(): void
    {
        $posts = Post::whereIn('id', $this->selectedItemIds)->get();

        foreach ($posts as $post) {
            $this->delete($post);
        }

        $this->resetSelected();
    }

    public function restore(Post $post): void
    {
        $this->authorize('restore', $post);

        $post->restore();
    }
}
