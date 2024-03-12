<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Data\Auth\CreateUserBlockHistoryData;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;

class SaveUnlockToHistory
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly UserBlockHistoryRepository $blockRepository
    ) {
    }

    /**
     * Handle the event.
     * 
     * @param \App\Events\Auth\UserUnlocked $event
     */
    public function handle($event): void
    {
        if (true === $event->isUnlocked()) {
            $data = new CreateUserBlockHistoryData(
                userId: $event->user->getKey(),
                action: UserBlockHistoryActionEnum::unlocked(),
                banDuration: null
            );

            $this->blockRepository->addToHistory($data);
        }
    }
}
