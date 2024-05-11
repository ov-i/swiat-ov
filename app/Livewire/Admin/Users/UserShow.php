<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserShow extends Component
{
    #[Locked, Url]
    public User $user;

    #[Computed]
    public function user(): User
    {
        return $this->user;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.users.user-show');
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
}
