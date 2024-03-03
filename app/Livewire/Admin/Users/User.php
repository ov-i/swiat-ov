<?php

namespace App\Livewire\Admin\Users;

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

    public function delete(int $userId): void
    {
        /** @var UserModel $user */
        $user = UserModel::find($userId);

        $this->authorize('delete', $user);

        if (null === $user) {
            return;
        }

        if ($user->isAdmin() || $user->isModerator()) {
            return;
        }

        event(new UserDeleted($user));

        $user->delete();

        session()->flash('user-deleted', "User with id [{$userId}] has been deleted.");
    }

    #[Layout('layouts.admin')]
    public function render(
        UserRepository $userRepository,
        UserActivityService $activityService,
    ) {
        $users = $userRepository->getAllUsers();

        return view('livewire.admin.users.user', [
            'users' => $users,
            'activityService' => $activityService,
        ]);
    }
}
