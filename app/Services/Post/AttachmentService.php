<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Data\CreateAttachmentRequest;
use App\Models\Posts\Attachment;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Services\UploadedFileService;

class AttachmentService extends UploadedFileService
{
    public function __construct(
        private readonly AttachmentRepository $attachmentRepository,
    ) {
        parent::__construct();
    }

    public function getResource(): string
    {
        return 'attachments';
    }

    public function storeOnDisk($disk = 'public'): void
    {
        $this->setUploadDir($this->getCurrentDate());

        parent::storeOnDisk($disk);
    }

    public function createAttachment(CreateAttachmentRequest $request): Attachment|bool
    {
        $this->makeUploadDir();
        $file = $this->setFile($request->attachment);

        $file->setUploadDir($this->getCurrentDate())
            ->storeOnDisk();

        $attachment = $this->attachmentRepository->createAttachment($this->toArray());

        return $attachment;
    }

    /**
     * Unlinks attachment from storage and deletes it from database
     */
    public function deleteAttachment(Attachment &$attachment, bool $forceDelete = false): bool
    {
        $this->unlinkFile($attachment->getFileName());

        return $this->attachmentRepository->deleteAttachment($attachment, $forceDelete);
    }

    public function getPublicUrl(): string
    {
        return asset("storage/{$this->getResource()}/{$this->getCurrentDate()}/{$this->getFileName()}");
    }

    /**
     * Checks if a checksum, already exists in database.
     *
     * @param string $checksum
     *
     * @return bool
     */
    public function checksumExists(string $checksum): bool
    {
        $attachment = $this->attachmentRepository->findAttachmentViaChecksum($checksum);

        return null !== $attachment;
    }

    protected function getRelativeLocation(): string
    {
        $resourceDir = parent::getRelativeLocation();

        return sprintf('%s/%s', $resourceDir, $this->getCurrentDate());
    }

}
