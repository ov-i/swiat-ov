<?php

namespace App\Livewire\Admin\Posts\Index;

use App\Livewire\Forms\PerPage;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Selectable;
use App\Livewire\Traits\Sortable;
use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    use Searchable;

    use Selectable;

    use Sortable;

    #[Reactive]
    public Filters $filters;

    #[Modelable]
    public PerPage $perPage;

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
        $posts = $this->applySorting($posts);
        $posts = $this->filters->apply($posts);

        $posts = $posts->paginate($this->perPage->slice->value);

        $this->itemIdsOnPage = collect($posts->items())
            ->map(fn (Post $post) => (string) $post->getKey())
            ->toArray();

        return view('livewire.admin.posts.index.table', [
            'posts' => $posts,
        ]);
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

    public function applySearch(Builder &$builder): Builder|ScoutBuilder
    {
        if (filled($this->search)) {
            return Post::search($this->search);
        }

        return $builder;
    }

    public function applySorting(Builder|ScoutBuilder &$builder): Builder|ScoutBuilder
    {
        if (filled($this->sortCol)) {
            $column = match ($this->sortCol) {
                'title' => 'title',
                'status' => 'status',
                'type' => 'type',
                'written_at' => 'created_at',
                'author' => 'user_id',
                'category' => 'category_id'
            };

            $builder->orderBy($column, $this->sortAsc ? 'asc' : 'desc');
        }

        return $builder;
    }
}
