<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Repositories\Eloquent\Posts\TagRepository;
use App\Rules\DoesntStartWithANumber;
use Illuminate\Validation\Rule;

class TagsCreate extends Resource
{
    public string $tag;

    /** @var TagRepository $repository */
    protected $repository = TagRepository::class;

    /**
     * @return non-empty-list<array-key, array<string, mixed>>
     */
    public function rules(): array
    {
        return [
            'tag' => [
                Rule::unique('tags', 'name'),
                new DoesntStartWithANumber(),
                'required',
                'min:2',
                'max:10',
            ]
        ];
    }

    public function addTag(): void
    {
        $this->authorize('write-tag');
        $this->validate();

        $this->repository->createTag($this->tag);

        $this->dispatch('tag-added');
    }

    protected function getView(): string
    {
        return 'posts.tags-create';
    }

    protected function getViewAttributes(): array
    {
        return [];
    }
}
