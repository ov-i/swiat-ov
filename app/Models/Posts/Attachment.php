<?php

namespace App\Models\Posts;

use Database\Factories\Posts\AttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attachment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'original_name',
        'filename',
        'checksum',
        'mimetype',
        'size',
        'location',
        'public_url'
    ];

    public function getOriginalName(): string
    {
        return $this->original_name;
    }

    public function getFileName(): string
    {
        return $this->filename;
    }

    public function getChecksum(): string
    {
        return $this->checksum;
    }

    public function getMimeType(): string
    {
        return $this->mimetype;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getPublicUrl(): ?string
    {
        return $this->public_url;
    }

    /**
     * @return BelongsToMany<Post, Attachment>
     */
    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * @return Factory<Attachment>
     */
    protected static function newFactory(): Factory
    {
        return AttachmentFactory::new();
    }
}
