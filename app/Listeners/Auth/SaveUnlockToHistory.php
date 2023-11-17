<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Events\Auth\UserUnlocked;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUnlockToHistory implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly UserBlockHistoryRepository $blockRepository
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserUnlocked $event): void
    {
        if (false === $event->isUnlocked()) {

            $this->blockRepository->addHistoryFrom(
                $event->user,
                UserBlockHistoryActionEnum::unlocked()
            );
        }
    }
}
