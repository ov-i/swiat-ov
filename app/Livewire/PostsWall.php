<?php

namespace App\Livewire;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class PostsWall extends Component
{
    use WithPagination;
    
    #[Computed, Locked]
    private readonly ?LengthAwarePaginator $posts;

    public function mount(?LengthAwarePaginator $posts): void
    {
        $this->posts = $posts;
    }

    public function render(): View
    {
        return view('livewire.posts-wall', [
            'posts' => $this->posts,
        ]);
    }
}
