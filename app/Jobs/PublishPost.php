<?php

namespace App\Jobs;

use App\Enums\Post\PostStatusEnum;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishPost implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Post $post
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var PostRepository $postRepository */
        $postRepository = app(PostRepository::class);

        $postRepository->setStatus($this->post, PostStatusEnum::published());
    }
}
