<?php

namespace App\Livewire\Admin\Posts;

use App\Enums\ItemsPerPageEnum;
use App\Livewire\Resource;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;

class PostShow extends Resource
{
    public Post $post;

    public bool $showImageModel = false;

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

    public function getThumbnail(): string
    {
        return $this->post()->getThumbnailPath();
    }

    public function getPublishDelay()
    {
        return now()->diff($this->post()->getPublishableDate())->forHumans();
    }

    public function getAttachments(): LengthAwarePaginator
    {
        return $this->post()->attachments()->paginate(ItemsPerPageEnum::DEFAULT);
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
