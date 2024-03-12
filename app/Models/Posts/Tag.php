<?php

namespace App\Models\Posts;

use Database\Factories\Posts\TagFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return BelongsToMany<Post>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return TagFactory::new();
    }
}
