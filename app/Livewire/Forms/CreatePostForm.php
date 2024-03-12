<?php

namespace App\Livewire\Forms;

use App\Data\CreatePostRequest;
use App\Enums\Post\PostTypeEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CreatePostForm extends Form
{
    public string $title = '';

    public string $type = '';

    public string $excerpt = '';

    public ?string $content = '';

    public int $categoryId = 0;

    /** @var array<array-key, int> $tags */
    public array $tags = [];

    /** @var ?UploadedFile $thumbnail */
    public $thumbnailPath = null;

    /** @var ?UploadedFile[] $attachments */
    public $attachments = null;

    public ?string $publishableDateTime = null;

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array
    {
        return [
            ...CreatePostRequest::rules(),
            'excerpt' => [
                Rule::requiredIf(fn () => PostTypeEnum::event()->value !== $this->type),
                'min:50',
                'max: 255',
                'nullable',
            ],
        ];
    }
}
