<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Models\Posts\Attachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

class AttachmentShow extends Resource
{
    public Attachment $attachment;

    #[Computed]
    public function attachment(): Attachment
    {
        return $this->attachment;
    }

    #[Computed]
    public function getAttachmentUser(): ?User
    {
        return $this->attachment()->user()->first();
    }

    #[Computed]
    public function getPosts(): ?Collection
    {
        return $this->attachment()->posts()->get();
    }

    protected function getView(): string
    {
        return 'posts.attachment-show';
    }

    protected function getViewAttributes(): array
    {
        return [];
    }
}
