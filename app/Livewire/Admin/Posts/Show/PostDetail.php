<?php

namespace App\Livewire\Admin\Posts\Show;

use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use App\Traits\InteractsWithModals;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PostDetail extends Component
{
    use InteractsWithModals;

    public bool $showImageModel = false;

    public bool $attachmentsModal = false;

    public Post $post;

    public function render(): View
    {
        return view('livewire.admin.posts.show.post-detail');
    }

    #[Computed]
    public function getPostUser(): User
    {
        return $this->post->user;
    }

    #[Computed]
    public function getCategory(): Category
    {
        return $this->post->category;
    }

    #[Computed]
    public function getThumbnail(): ?string
    {
        return $this->post->getThumbnailPath();
    }

    /**
     * @return void|string
     */
    #[Computed]
    public function getPublishDelay()
    {
        $publishableDate = Carbon::parse($this->post->getScheduledAt());
        if ($publishableDate === null) {
            return;
        }

        /** @disregard P1013 */
        return now()->diff($publishableDate)->forHumans();
    }
}
