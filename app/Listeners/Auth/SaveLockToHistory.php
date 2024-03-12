<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Data\Auth\CreateUserBlockHistoryData;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Events\Auth\UserLocked;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;

class SaveLockToHistory
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly UserBlockHistoryRepository $blockRepository,
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserLocked $event): void
    {
        if (false === $event->isLocked()) {
            return;
        }

        $data = new CreateUserBlockHistoryData(
            userId: $event->user->getKey(),
            action: UserBlockHistoryActionEnum::locked(),
            banDuration: $event->lockOption->getDuration()->value,
        );

        $this->blockRepository->addToHistory($data);
    }
}
