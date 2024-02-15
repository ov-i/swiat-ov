<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Models\Posts\Tag;
use App\Repositories\Eloquent\BaseRepository;

class TagRepository extends BaseRepository
{
    public function __construct(
        private readonly Tag $tag
    ) {
        parent::__construct($tag);
    }

    public function findWithName(string $name): ?Tag
    {
        return $this->getModel()->query()
            ->where('name', $name)
            ->first();
    }

    public function createTag(array $tagData): Tag
    {
        return $this->create($tagData);
    }
}