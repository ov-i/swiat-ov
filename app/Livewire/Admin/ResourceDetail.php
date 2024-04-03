<?php

namespace App\Livewire\Admin;

use App\Livewire\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;

class ResourceDetail extends Resource
{
    /** @var Model $resourceClass */
    #[Modelable]
    public $resourceClass;

    #[Modelable]
    public string $resourceName;

    public function mount(): void
    {
        $user = auth()->user();
        $this->authorize(sprintf('view-%s', $this->resourceName));
        $this->authorize('viewAdmin', $user);
    }

    #[Computed]
    public function resource(): Model
    {
        $resource = $this->resourceClass;

        return $resource;
    }

    public function resourceNamePlural(): string
    {
        return Str::plural($this->resourceName);
    }

    public function generateListLink(): string
    {
        return route(sprintf('admin.%s', $this->resourceNamePlural()));
    }

    public function generateEditLink(): string
    {
        return route(sprintf('admin.%s.edit', $this->resourceNamePlural()), [
            $this->resourceName => $this->resource()
        ]);
    }

    protected function getView(): string
    {
        return 'resource-detail';
    }

    protected function getViewAttributes(): array
    {
        return [];
    }
}
