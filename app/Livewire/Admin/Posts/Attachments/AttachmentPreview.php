<?php

namespace App\Livewire\Admin\Posts\Attachments;

use App\Traits\FormatsString;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AttachmentPreview extends Component
{
    use FormatsString;

    /** @var non-empty-list<array-key, \Illuminate\Http\UploadedFile> $attachments */
    #[Modelable]
    public ?array $attachments = [];

    public function render()
    {
        return view('livewire.admin.posts.attachments.attachment-preview');
    }
}
