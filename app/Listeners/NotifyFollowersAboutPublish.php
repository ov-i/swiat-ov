<?php

namespace App\Listeners;

use App\Events\Post\PostPublished;

class NotifyFollowersAboutPublish
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        //
    }
}
