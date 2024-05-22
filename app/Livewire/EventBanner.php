<?php

namespace App\Livewire;

use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EventBanner extends Component
{
    private PostRepository $postRepository;

    public function boot(
        PostRepository $postRepository
    ): void {
        $this->postRepository = $postRepository;
    }

    #[Computed]
    public function event(): ?Post
    {
        return $this->postRepository->getPublishedEvent();
    }
}
