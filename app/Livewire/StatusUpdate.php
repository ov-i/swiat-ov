<?php

namespace App\Livewire;

use App\Enums\Post\PostStatusEnum;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Traits\InteractsWithModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\LaravelData\Attributes\Validation\In;

class StatusUpdate extends Component
{
    use InteractsWithModals;

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
        $this->authorize('can-edit-post', [$this->post]);
        $this->validate();

        $postRepository = new PostRepository();

        if ($this->newStatus === PostStatusEnum::closed()->value && !Gate::allows('can-close-post')) {
            $this->addError('newStatus', __("You're not allowed to close the posts"));

            return;
        }

        $postRepository->setStatus($this->post, PostStatusEnum::from($this->newStatus));

        $this->closeModal();

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
            PostStatusEnum::draft()
        ];

        if (Gate::allows('can-close-post')) {
            $availableStatus[] = PostStatusEnum::closed();
        }

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
