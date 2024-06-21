<?php

namespace App\Jobs;

use App\Events\Auth\UserUnlocked;
use App\Models\User;
use App\Services\Auth\UserLockService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnlockUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User &$user,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(UserLockService $userLockService): void
    {
        $userLockService->unlockUser($this->user);

        event(new UserUnlocked($this->user));
    }
}
