<?php

namespace App\Models\Posts;

use Database\Factories\Posts\AttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Attachment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'post_id',
        'original_name',
        'filename',
        'checksum',
        'mimetype',
        'size',
        'location'
    ];

    /**
     * @return BelongsTo<Post, Attachment>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return Factory<Attachment>
     */
    protected static function newFactory(): Factory
    {
        return AttachmentFactory::new();
    }
}
