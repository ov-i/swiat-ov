<?php

namespace App\Livewire\Admin\Resources\Authorization;

use App\Events\Auth\UserDeleted;
use App\Models\User as UserModel;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\UserActivity\UserActivityService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    public bool $userLocked = false;

    public function delete(int $userId): void
    {
        /** @var UserModel $user */
        $user = UserModel::find($userId);

        if (null === $user) {
            return;
        }

        event(new UserDeleted($user));

        if ($user->isAdmin() || $user->isModerator()) {
            return;
        }

        $user->delete();

        session()->flash('user-deleted', "User with id [{$userId}] has been deleted.");
    }

    #[Layout('layouts.admin')]
    public function render(
        UserRepository $userRepository,
        UserActivityService $activityService,
    ) {
        $users = $userRepository->getAllUsers();

        return view('livewire.admin.resources.authorization.user', [
            'users' => $users,
            'activityService' => $activityService,
        ]);
    }
}
