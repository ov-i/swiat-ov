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

    public function createAttachment(CreateAttachmentRequest $request): Attachment|false
    {
        $this->makeUploadDirWithDate();
        $this->setFile($request->attachment)
            ->createFileName()
            ->storeOnDisk();

        $attachment = $this->attachmentRepository->findAttachmentViaChecksum($this->getChecksum());
        if (true === $this->checksumExists($this->getChecksum())) {
            $this->setChecksum($attachment->checksum);
        }

        $attachment = $this->attachmentRepository->createAttachment([
            ...$this->toArray(),
            'public_url' => $this->getPublicUrl(),
        ]);

        return $attachment;
    }

    /**
     * Unlinks the
     */
    public function deleteAttachment(Attachment &$attachment): bool
    {
        $this->unlinkFile($attachment->getFileName());

        return $this->attachmentRepository->deleteAttachment($attachment);
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
}
