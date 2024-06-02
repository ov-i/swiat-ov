<?php

namespace App\Livewire\Forms;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Enums\Post\ThumbnailAllowedMimeTypesEnum;
use App\Enums\PostType;
use App\Models\Posts\Post;
use App\Rules\AllowOnlySpecificSpecialChars;
use App\Rules\DateTimeGreaterThanNow;
use App\Rules\DoesntStartWithANumber;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    #[Validate]
    public string $title = '';

    public PostType $type = PostType::Post;

    public string $excerpt = '';

    public ?string $content = '';

    public int $category_id = 0;

    /** @var array<array-key, int> $tags */
    public array $tags = [];

    /** @var ?UploadedFile $thumbnail */
    public $thumbnail_path = null;

    /** @var Collection<array-key, int> $attachments */
    public $attachments = [];

    public ?string $scheduled_publish_date = null;

    public Post $post;

    public function init(Post $post): void
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->type = $post->getType();
        $this->excerpt = $post->getExcerpt();
        $this->content = $post->getContent();
        $this->category_id = $post->category()->getParentKey();
        $this->scheduled_publish_date = $post->getScheduledAt();
    }

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array
    {
        $titleUnique = Rule::unique('posts', 'title');

        if (isset($this->post)) {
            $titleUnique->ignore($this->post->getKey());
        }

        return [
            'title' => [
                'min:3',
                'max:120',
                'doesnt_start_with:<',
                new DoesntStartWithANumber(),
                new AllowOnlySpecificSpecialChars(),
                $titleUnique,
                'required',
            ],
            'type' => [
                'required'
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
                'numeric'
            ],
            'tags.*' => [
                'nullable',
                Rule::exists('tags', 'id'),
                'numeric'
            ],
            'attachments.*' => [
                'nullable',
                'numeric',
                Rule::exists('attachments', 'id'),
            ],
            'thumbnail_path' => [
                'nullable',
                Rule::imageFile()
                    ->extensions([...ThumbnailAllowedMimeTypesEnum::toLabels()])
                    ->max(config('swiatov.max_file_size')),
            ],
            'scheduled_publish_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
                new DateTimeGreaterThanNow()
            ],
            'content' => [
                'max:10000',
                'required',
                new DoesntStartWithANumber(),
                'min:10',
            ],
            'excerpt' => [
                Rule::requiredIf(fn () => PostType::Event !== $this->type),
                'min:50',
                'max:255',
                'nullable',
            ],
        ];
    }

    public function setPost(Post &$post): void
    {
        $this->post = $post;
    }

    #[Computed]
    public function isEvent(): bool
    {
        return $this->type === PostType::Event;
    }

    #[Computed]
    public function isScheduled(): bool
    {
        return filled($this->scheduled_publish_date);
    }

    #[Computed]
    public function getPostPublicUri(): string
    {
        $host = config('app.url');
        $slugableTitle = Str::slug($this->title);

        return sprintf('%s/%s', $host, $slugableTitle);
    }

    #[Computed]
    public function getPostTypesOptions(): array
    {
        return PostType::cases();
    }

    #[Computed]
    public function getAcceptedMimeTypes(): array
    {
        return AttachmentAllowedMimeTypesEnum::toValues();
    }
}
