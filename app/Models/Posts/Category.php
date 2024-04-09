<?php

namespace App\Models\Posts;

use Database\Factories\Posts\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stringable;

class Category extends Model implements Stringable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return Factory<Category>
     */
    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
