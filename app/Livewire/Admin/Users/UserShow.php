<?php

namespace App\Livewire\Admin\Users;

use App\Events\User\UserProfileImageDeleted;
use App\Livewire\Resource;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\Users\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;

class UserShow extends Resource
{
    #[Locked, Url]
    public User $user;

    /** @var UserRepository $repository */
    protected $repository = UserRepository::class;

    private UserService $userService;

    public function mount(
        UserService $userService
    ): void {
        $this->userService = $userService;
    }

    #[Computed]
    public function user(): User
    {
        return $this->user;
    }

    public function deleteImage(): void
    {
        $user = $this->user();

        $user->deleteProfilePhoto();

        session()->flash('User image has been deleted');

        event(new UserProfileImageDeleted($user));
    }

    #[Computed]
    public function getPosts(): ?LengthAwarePaginator
    {
        return $this->user()
            ->posts()
            ->select(['id', 'title', 'type', 'status', 'slug'])
            ->paginate($this->perPage);
    }

    #[Computed]
    public function getAttachments(): ?LengthAwarePaginator
    {
        return $this->user()
            ->attachments()
            ->select(['id', 'original_name', 'mimetype', 'size'])
            ->paginate($this->perPage);
    }

    #[Computed]
    public function getRoles(): ?Collection
    {
        return $this->user()
            ->roles()
            ->select(['name', 'guard_name'])
            ->get();
    }

    protected function getView(): string
    {
        return 'users.user-show';
    }
}
