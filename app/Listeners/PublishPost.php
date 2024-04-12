<?php

namespace App\Listeners;

use App\Enums\Post\PostHistoryActionEnum;
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

        if (blank($post->getPublishableDate())) {
            $this->postRepository->setStatus($post, PostStatus::Published);
            $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::published());

            return;
        }

        $this->postRepository->setStatus($post, PostStatus::Delayed);
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::delayed());

        $delayDiff = Carbon::parse($post->getPublishableDate(), config('app.timezone'))->diffInSeconds();

        \App\Jobs\PublishPost::dispatch($post)->delay($delayDiff);
    }
}
