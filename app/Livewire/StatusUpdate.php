<?php

namespace App\Livewire;

use App\Enums\Post\PostStatusEnum;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\LaravelData\Attributes\Validation\In;

class StatusUpdate extends Component
{
    public bool $statusUpdate = false;

    public Post $post;

    public string $newStatus;

    /**
     * Defines an array for available explicits status that can be changed.
     *
     * @return non-empty-list<array-key, PostStatusEnum>
     */
    private array $availableExcplicitStatus = [];

    public function mount(): void
    {
        $this->newStatus = $this->post->getStatus();
    }

    public function updateStatus(): void
    {
        $this->authorize('canEditPost', [$this->post]);
        $this->validate();

        $postRepository = new PostRepository();

        $postRepository->setStatus($this->post, PostStatusEnum::from($this->newStatus));

        $this->statusUpdate = false;

        $this->redirectRoute('admin.posts.edit', ['post' => $this->post]);
    }

    /**
     * @return non-empty-list<array-key, PostStatusEnum>
     */
    #[Computed(persist: true)]
    public function getAvailableExcplicitStatus(): array
    {
        $availableStatus = [
            PostStatusEnum::published(),
            PostStatusEnum::archived(),
            PostStatusEnum::closed(),
            PostStatusEnum::draft()
        ];

        foreach(PostStatusEnum::cases() as $status) {
            if (!in_array($status->value, $availableStatus, true)) {
                continue;
            }

            $availableStatus[] = $status;
        }

        return $availableStatus;
    }

    /**
     * @return non-empty-list<string, array<array-key, mixed>>
     */
    public function rules(): array
    {
        return [
            'newStatus' => [
                new In(
                    PostStatusEnum::published()->value,
                    PostStatusEnum::archived()->value,
                    PostStatusEnum::closed()->value,
                    PostStatusEnum::draft()->value
                )
            ]
        ];
    }

    public function render()
    {
        return view('livewire.status-update');
    }
}
