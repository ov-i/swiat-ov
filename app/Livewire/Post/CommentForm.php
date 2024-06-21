<?php

namespace App\Livewire\Post;

use App\Data\CommentData;
use App\Livewire\Forms\CreateComment;
use App\Models\Posts\Post;
use App\Services\Post\CommentService;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CommentForm extends Component
{
    use WithRateLimiting;

    #[Locked]
    public Post $post;

    public CreateComment $createComment;

    private CommentService $commentService;

    public function boot(
        CommentService $commentService
    ): void {
        $this->commentService = $commentService;
    }

    public function render(): View
    {
        return view('livewire.post.comment-form');
    }

    public function save(): void
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'too_many_request' => __('Tylko 2 komentarze/min'),
            ]);
        }

        $this->authorize('create-comment');

        $this->createComment->validate();

        $content = htmlspecialchars(string: $this->createComment->content);

        $commentData = new CommentData($content);

        $comment = $this->commentService->createComment($this->post, $commentData);

        $this->dispatch('post.comment-added', user: auth()->user(), content: $comment->getContent());
    }
}
