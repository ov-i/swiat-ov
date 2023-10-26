<?php

namespace App\Models\Posts;

use Database\Factories\Posts\LangPostFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LangPost extends Model
{
    use HasFactory;

    protected $table = 'lang_post';

    protected $fillable = [
        'post_id',
        'langs'
    ];

    /**
     * @return BelongsTo<Post, self>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return LangPostFactory::new();
    }
}
