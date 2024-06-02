<?php

namespace App\Listeners;

use App\Enums\Post\PostHistoryAction;
use App\Enums\PostStatus;
use App\Events\PostPublished;
use App\Repositories\Eloquent\Posts\PostHistoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use Illuminate\Support\Carbon;

class PublishPost
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly PostHistoryRepository $postHistoryRepository,
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $post = $event->post;

        if (blank($post->getScheduledAt())) {
            $this->postRepository->setStatus($post, PostStatus::Published);
            $this->postHistoryRepository->addHistory($post, PostHistoryAction::Published);

            return;
        }

        $this->postRepository->setStatus($post, PostStatus::Scheduled);
        $this->postHistoryRepository->addHistory($post, PostHistoryAction::Scheduled);

        $delayDiff = abs(Carbon::parse($post->getScheduledAt(), config('app.timezone'))->diffInSeconds());
        \App\Jobs\PublishPost::dispatch($post)->delay($delayDiff);
    }
}
