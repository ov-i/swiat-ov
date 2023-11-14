<?php

namespace App\Jobs;

use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearUserBlock implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly AuthRepository $authRepository
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (User::all() as $user) {
            if (
                true === $user->isBlocked() &&
                $this->authRepository->isBanDurationOver($user)
            ) {
                $this->authRepository->unlockUser($user);
                $user->notify(new \App\Notifications\NotifyAboutUnlock($user));
            }
        }
    }
}
