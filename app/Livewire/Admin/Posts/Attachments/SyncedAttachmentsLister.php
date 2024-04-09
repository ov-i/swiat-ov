<?php

namespace App\Livewire\Admin\Posts\Attachments;

use App\Exceptions\AttachmentNotFound;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use Illuminate\Support\Collection;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class SyncedAttachmentsLister extends Component
{
    /** @var Collection $attachments */
    #[Modelable]
    public $attachments = [];

    private AttachmentRepository $attachmentRepository;

    public function boot(
        AttachmentRepository $attachmentRepository
    ): void {
        $this->attachmentRepository = $attachmentRepository;
    }

    public function render()
    {
        return view('livewire.admin.posts.attachments.synced-attachments-lister');
    }

    #[On('attachments-sync')]
    public function syncAttachments(array $ids): void
    {
        $this->authorize('post-sync-attachments', auth()->user());

        $this->attachments = [...$ids];
    }

    public function getAttachmentName(int $attachment): ?string
    {
        $attachment = $this->attachmentRepository->find($attachment);

        if (blank($attachment)) {
            throw new AttachmentNotFound();
        }

        return $attachment->getFileName();
    }
}
