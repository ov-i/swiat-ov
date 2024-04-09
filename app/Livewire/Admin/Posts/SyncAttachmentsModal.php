<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Posts\Attachment;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Traits\FormatsString;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SyncAttachmentsModal extends Component
{
    use FormatsString;

    #[Modelable]
    public bool $attachmentsModal = false;

    public bool $showOnlySelected = false;

    public Collection $attachments;

    /** @var SupportCollection<int, string> */
    public SupportCollection $attachmentsToSync;

    private AttachmentRepository $attachmentRepository;

    public function __construct()
    {
        $this->attachmentsToSync = new SupportCollection();
    }

    public function boot(
        AttachmentRepository $attachmentRepository,
    ): void {
        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * @return Collection<int, Attachment>
     */
    #[Computed(persist: true)]
    public function attachments(): Collection
    {
        $this->attachments = $this->attachmentRepository->all(paginate: false);

        if ($this->showOnlySelected && filled($this->attachmentsToSync)) {
            $this->attachments = $this->attachments->filter(function (Attachment $attachment) {
                return $this->attachmentsToSync->contains($attachment->getKey());
            });
        }

        return $this->attachments;
    }

    public function render()
    {
        return view('livewire.admin.posts.sync-attachments-modal');
    }

    public function rules(): array
    {
        return [
            'attachmentsToSync.*' => [
                Rule::exists('attachments', 'id'),
                'required',
                'numeric',
            ],
        ];
    }

    public function toggle(int $id): void
    {
        $attachmentsToSync = $this->attachmentsToSync;

        if (!$attachmentsToSync->contains($id)) {
            $attachmentsToSync->add($id);
        } else {
            $index = $attachmentsToSync->search($id);

            $index !== false ? $attachmentsToSync->splice($index, 1) : null;
        }
    }

    public function save(): void
    {
        $this->authorize('post-sync-attachments', auth()->user());

        $attachmentsToSync = $this->attachmentsToSync->collect()->unique();

        $this->dispatch('attachments-sync', ids: $attachmentsToSync);
        $this->attachmentsModal = false;
    }

    protected function isAdded(int $attachment): bool
    {
        return $this->attachmentsToSync->contains($attachment);
    }
}
