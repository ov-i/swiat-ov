<?php

namespace App\Livewire\Admin\Users\Index;

use App\Livewire\Forms\PerPage;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Selectable;
use App\Livewire\Traits\Sortable;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    use Searchable;

    use Selectable;

    use Sortable;

    #[Reactive]
    public Filters $filters;

    #[Modelable]
    public PerPage $perPage;

    private UserService $userService;

    public function boot(
        UserService $userService,
    ): void {
        $this->authorize('viewAny', auth()->user())->asNotFound();

        $this->userService = $userService;
    }

    public function render(): View
    {
        $users = User::query();

        $users = $this->applySearch($users);
        $users = $this->applySorting($users);
        $users = $this->filters->apply($users);

        $users = $users->paginate($this->perPage->slice->value);

        $this->itemIdsOnPage = collect($users->items())
            ->map(fn (User $user) => (string) $user->getKey())
            ->toArray();

        return view('livewire.admin.users.index.table', [
            'users' => $users,
        ]);
    }

    public function delete(User $user): void
    {
        $this->authorize('delete', $user)->asNotFound(); // anti bots scan

        $this->userService->deleteUser($user);
    }

    public function deleteSelected(): void
    {
        $users = User::whereIn('id', $this->selectedItemIds)->get();

        foreach ($users as $user) {
            $this->delete($user);
        }

        $this->resetSelected();
    }

    public function restore(User $user): void
    {
        $this->authorize('restore', $user);

        if (!$user->trashed()) {
            return;
        }

        $user->restore();
    }

    public function applySearch(Builder &$builder): Builder
    {
        if (filled($this->search)) {
            return $builder->where(function() use (&$builder) {
                $builder->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . (int) $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('ip', 'like', '%' . $this->search . '%');

                return $builder;
            });
        }

        return $builder;
    }

    public function applySorting(Builder &$builder): Builder
    {
        $sortDirection = $this->sortAsc === 'asc' ? 'asc' : 'desc';

        if (filled($this->sortCol)) {
            $column = match ($this->sortCol) {
                'author' => ['name', 'email'],
                'ip' => 'ip',
                'status' => 'status',
                'created_at' => 'created_at',
            };

            if (is_array($column)) {
                foreach ($column as $col) {
                    $builder->orderBy($col, $sortDirection);
                }

                return $builder;
            }
            
            $builder->orderBy($column, $sortDirection);
        }

        return $builder;
    }
}
