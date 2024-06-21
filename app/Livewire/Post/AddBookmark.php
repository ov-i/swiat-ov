<?php

namespace App\Livewire\Post;

use App\Models\Posts\Post;
use App\Models\User;
use App\Repositories\Eloquent\Posts\UserPostFollowRepository;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class AddBookmark extends Component
{
    use WithRateLimiting;

    #[Modelable, Locked]
    public Post $post;

    #[Modelable, Locked]
    public User $user;

    public bool $alreadyFollowed = false;

    private UserPostFollowRepository $userPostRepository;

    public function boot(
        UserPostFollowRepository $userPostRepository,
    ): void {
        $this->userPostRepository = $userPostRepository;
    }

    public function render(): View
    {
        $this->alreadyFollowed = $this->post->isFollowed($this->user);
        return view('livewire.post.add-bookmark');
    }

    public function toggleBookmark(): bool
    {
        $this->authorize('can-follow', $this->post);

        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            abort(Response::HTTP_TOO_MANY_REQUESTS, $exception->getMessage());
        }

        if ($this->alreadyFollowed) {
            return $this->userPostRepository->unfollowPost($this->post, $this->user);
        }

        return $this->userPostRepository->followPost($this->post, $this->user);
    }
}
