<?php

namespace App\Events;

use App\Models\Posts\Post;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostPublished
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    use InteractsWithQueue;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Post $post
    ) {
    }
}
