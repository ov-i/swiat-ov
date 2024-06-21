<?php

namespace App\Livewire\Admin\Posts\Show\Relations;

use App\Models\Posts\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Tags extends Component
{
    #[Modelable]
    public Post $post;

    public function render(): View
    {
        return view('livewire.admin.posts.show.relations.tags');
    }

    #[Computed]
    public function getTags(): Collection
    {
        return $this->post->tags()->get();
    }
}
