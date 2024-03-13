<?php

namespace App\Livewire\Forms;

use App\Data\UpdatePostData;
use App\Enums\Post\PostTypeEnum;
use App\Models\Posts\Post;
use App\Rules\AllowOnlySpecificSpecialChars;
use App\Rules\DoesntStartWithANumber;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdatePostForm extends Form
{
    public string $title;

    public string $type;

    public ?string $excerpt;

    public string $content;

    public int $category_id;

    /** @var array<array-key, int> $tags */
    public array $tags = [];

    /** @var ?UploadedFile[] $attachments */
    public ?array $attachments = [];

    public ?UploadedFile $thumbnailPath = null;

    /**
     * @return array<array-key, mixed>
     */
    public function rules()
    {
        $title = $this->title;

        return [
            ...UpdatePostData::rules(),
            'excerpt' => [
                Rule::requiredIf(fn () => PostTypeEnum::event()->value !== $this->type),
                'min:50',
                'max: 255',
                'nullable',
            ],
             'title' => [
                'nullable',
                new DoesntStartWithANumber(),
                new AllowOnlySpecificSpecialChars(),
                'doesnt_start_with:<',
                Rule::requiredIf(function () use ($title) {
                    $post = Post::where('title', $title)->first();

                    return !blank($post) && $title !== $post->getTitle();
                })
            ]
        ];
    }

}
