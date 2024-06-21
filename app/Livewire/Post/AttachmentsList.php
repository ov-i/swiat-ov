<?php

namespace App\Livewire\Post;

use App\Models\Posts\Attachment;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AttachmentsList extends Component
{
    #[Modelable, Locked]
    /** @var Collection<int, Attachment> */
    public Collection $attachments;

    public function render()
    {
        return view('livewire.post.attachments-list');
    }

    #[Computed]
    public function attachments(): Collection
    {
        return $this->attachments;
    }
}
