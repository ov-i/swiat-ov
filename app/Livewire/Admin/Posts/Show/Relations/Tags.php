<?php

namespace App\Livewire\Admin\Posts\Show\Relations;

use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Tags extends Component
{
    public Post $post;

    public function render()
    {
        return view('livewire.admin.posts.show.relations.tags');
    }

    #[Computed]
    public function getTags(): Collection
    {
        return $this->post->tags()->get();
    }
}
