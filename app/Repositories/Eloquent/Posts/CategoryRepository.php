<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Exceptions\CategoryAlreadyExistsException;
use App\Models\Posts\Category;
use App\Repositories\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function createCategory(string $name): Category
    {
        $existingCategory = $this->findBy('name', $name);

        if (null !== $existingCategory) {
            throw new CategoryAlreadyExistsException();
        }

        return $this->create(['name' => $name]);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return Category::class;
    }
}
