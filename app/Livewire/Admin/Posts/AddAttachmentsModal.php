<?php

namespace App\Livewire\Admin\Posts;

use App\Data\CreateAttachmentRequest;
use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Livewire\Forms\AddAttachmentForm;
use App\Livewire\Resource;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Services\Post\AttachmentService;
use App\Traits\InteractsWithModals;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

class AddAttachmentsModal extends Resource
{
    use WithFileUploads;
    use InteractsWithModals;

    public bool $showSaveButton = false;

    public AddAttachmentForm $addAttachmentForm;

    protected $repository = AttachmentRepository::class;

    private AttachmentService $attachmentService;

    public function mount(
        AttachmentService $attachmentService,
    ): void {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Saves the optional attachments from request
     *
     * @return void
     */
    public function addAttachments(AttachmentService $attachmentService): void
    {
        $this->authorize('create-attachment', auth()->user());

        $this->addAttachmentForm->validate();

        $files = $this->addAttachmentForm->attachments;

        foreach ($files as $file) {
            $attachmentService->setFile($file);

            $request = new CreateAttachmentRequest(attachment: $attachmentService->getContent());

            $attachmentService->createAttachment($request);
        }

        $this->redirectRoute('admin.attachments', navigate: true);
        $this->closeModal();
    }

    #[Computed]
    public function getAllowedMimeTypes(): array
    {
        return AttachmentAllowedMimeTypesEnum::toValues();
    }

    protected function getView(): string
    {
        return 'posts.add-attachments-modal';
    }

    protected function getViewAttributes(): array
    {
        return [];
    }
}
