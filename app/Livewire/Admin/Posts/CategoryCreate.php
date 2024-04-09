<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Repositories\Eloquent\Posts\CategoryRepository;
use App\Rules\DoesntStartWithANumber;
use Illuminate\Validation\Rule;

class CategoryCreate extends Resource
{
    public string $category;

    /** @var CategoryRepository $repository */
    protected $repository = CategoryRepository::class;

    /**
     * @return non-empty-list<array-key, array<string, mixed>>
     */
    public function rules(): array
    {
        return [
            'category' => [
                Rule::unique('categories', 'name'),
                new DoesntStartWithANumber(),
                'required',
                'min:2',
                'max:10',
            ]
        ];
    }

    public function addCategory(): void
    {
        $this->authorize('write-category');
        $this->validate();

        $this->repository->createCategory($this->category);

        $this->dispatch('category-added');
    }

    protected function getView(): string
    {
        return 'posts.category-create';
    }

    protected function getViewAttributes(): array
    {
        return [];
    }
}
