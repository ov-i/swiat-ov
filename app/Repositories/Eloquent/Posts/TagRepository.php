<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Exceptions\TagAlreadyExistsException;
use App\Models\Posts\Tag;
use App\Repositories\Eloquent\BaseRepository;

class TagRepository extends BaseRepository
{
    public function findWithName(string $name): ?Tag
    {
        return $this->findBy('name', $name);
    }

    public function createTag(string $name): Tag
    {
        $tag = $this->findWithName($name);
        if (filled($tag)) {
            throw new TagAlreadyExistsException();
        }

        return $this->create(['name' => $name]);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return Tag::class;
    }
}
