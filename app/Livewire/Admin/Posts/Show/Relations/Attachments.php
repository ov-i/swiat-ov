<?php

namespace App\Livewire\Admin\Posts\Show\Relations;

use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Attachments extends Component
{
    public Post $post;

    public function render()
    {
        return view('livewire.admin.posts.show.relations.attachments');
    }

    #[Computed]
    public function getAttachments(): Collection
    {
        return $this->post->attachments()->get();
    }
}
