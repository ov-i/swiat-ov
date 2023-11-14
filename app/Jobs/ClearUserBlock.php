<?php

namespace App\Jobs;

use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\Auth\AuthService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
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
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        /** @var AuthService $authService */
        $authService = app(AuthService::class);

        /** @var Collection<int, User> $blockedUsers */
        $blockedUsers = $userRepository->getUsersByStatus(UserStatusEnum::banned());
        if ($blockedUsers->isEmpty()) {
            return;
        }

        foreach ($blockedUsers as $user) {
            if (
                true === $user->isBlocked() &&
                $authService->isBanDurationOver($user)
            ) {
                $authService->unlockUser($user);
            }
        }
    }
}
