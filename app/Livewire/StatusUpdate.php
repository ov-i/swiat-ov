<?php

namespace App\Livewire;

use App\Enums\PostStatus;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Traits\InteractsWithModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;

class StatusUpdate extends Component
{
    use InteractsWithModals;

    public Post $post;

    public PostStatus $newStatus;

    /**
     * Defines an array for available explicits status that can be changed.
     *
     * @return non-empty-list<array-key, PostStatus>
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

        if ($this->newStatus === PostStatus::Closed && !Gate::allows('can-close-post')) {
            $this->addError('newStatus', __("You're not allowed to close the posts"));

            return;
        }

        $postRepository->setStatus($this->post, $this->newStatus);

        $this->closeModal();

        $this->redirectRoute('admin.posts.edit', ['post' => $this->post]);
    }

    /**
     * @return non-empty-list<array-key, PostStatus>
     */
    #[Computed(persist: true)]
    public function getAvailableExcplicitStatus(): array
    {
        $availableStatus = [
            PostStatus::Published,
            PostStatus::Archived,
            PostStatus::Draft
        ];

        if (Gate::allows('can-close-post')) {
            $availableStatus[] = PostStatus::Closed;
        }

        foreach(PostStatus::cases() as $status) {
            if (!in_array($status->value, $availableStatus, true)) {
                continue;
            }

            $availableStatus[] = $status;
        }

        return $availableStatus;
    }

    public function render()
    {
        return view('livewire.status-update');
    }
}
