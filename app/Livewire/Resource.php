<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\ItemsPerPageEnum;
use App\Traits\FormatsString;
use App\Traits\InteractsWithModals;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

abstract class Resource extends Component
{
    use InteractsWithModals;
    use WithPagination;
    use FormatsString;

    public int $perPage = ItemsPerPageEnum::DEFAULT;

    public bool $paginate = true;

    public bool $withTrashed = false;

    protected ?string $layout = 'layouts.admin';

    /** @var class-string<\App\Repositories\Eloquent\BaseRepository> $repository */
    protected $repository = null;

    abstract protected function getView(): string;

    public function __construct()
    {
        if (filled($this->repository)) {
            $repository = new $this->repository();

            $this->repository = $repository;
        }
    }

    public function render(): View
    {
        $view = view($this->getDefaultAdminViewPath(), [...$this->getViewAttributes()]);

        $view->layout($this->layout);

        return $view;
    }

    public function getUser(): Authenticatable
    {
        return auth()->user();
    }

    /**
     * @return array<array-key, mixed>
     */
    protected function getViewAttributes(): array
    {
        return [
            'resource' => $this->repository->all(
                paginate: $this->paginate,
                perPage: $this->perPage,
                withTrashed: $this->withTrashed,
            ),
        ];
    }

    private function getDefaultAdminViewPath(): string
    {
        $adminViewPath = Str::replace('/', '.', config('livewire.admin_view_path'));

        return sprintf('%s%s', $adminViewPath, $this->getView());
    }
}
