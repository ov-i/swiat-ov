<?php

namespace App\Livewire\Post\Widget;

use App\Data\CommentData;
use App\Enums\ItemsPerPage;
use App\Livewire\Forms\CreateComment;
use App\Models\Posts\Post;
use App\Services\Post\CommentService;
use App\Services\Post\PostService;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;
    use WithRateLimiting;

    #[Locked]
    public Post $post;

    public CreateComment $createComment;

    protected LengthAwarePaginator $comments;

    private PostService $postService;

    private CommentService $commentService;

    public function boot(
        PostService $postService,
        CommentService $commentService,
    ): void {
        $this->postService = $postService;
        $this->commentService = $commentService;
    }

    public function render(): View
    {
        $this->comments = $this->postService->getAcceptedComments($this->post)->paginate(ItemsPerPage::Default->value);

        return view('livewire.post.widget.comments')->with(['comments' => $this->comments]);
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

        $content = $this->createComment->content;

        $commentData = new CommentData($content);

        $this->commentService->createComment($this->post, $commentData);
    }
}
