<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;

class PostShow extends Resource
{
    public Post $post;

    public bool $showImageModel = false;

    public bool $attachmentsModal = true;

    #[Computed]
    public function post(): Post
    {
        return $this->post;
    }

    public function getPostUser(): User
    {
        return $this->post()->user()->first();
    }

    public function getCategory(): Category
    {
        return $this->post()->category()->first();
    }

    public function getThumbnail(): ?string
    {
        return $this->post()->getThumbnailPath();
    }

    /**
     * @return void|string
     */
    public function getPublishDelay()
    {
        $publishableDate = Carbon::parse($this->post()->getPublishableDate());
        if ($publishableDate === null) {
            return;
        }

        return now()->diff($publishableDate)->forHumans();
    }

    public function getAttachments(): Collection
    {
        return $this->post()->attachments()->get();
    }

    protected function getView(): string
    {
        return 'posts.post-show';
    }

    protected function getViewAttributes(): array
    {
        return [];
    }
}
