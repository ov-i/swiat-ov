<?php

namespace App\Livewire\Post;

use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\UserPostFollowRepository;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class PostFollow extends Component
{
    #[Locked, Computed]
    public Post $post;

    private readonly UserPostFollowRepository $userPostFollowRepository;

    public function mount(
        UserPostFollowRepository $userPostFollowRepository,
    ): void {
        $this->userPostFollowRepository = $userPostFollowRepository;
    }

    public function followPost(): void
    {
        $user = auth()->user();

        abort_if(blank($user), 401, 'You must be logged in to follow this post.');

        $this->userPostFollowRepository->followPost($this->post, $user);
    }
}
