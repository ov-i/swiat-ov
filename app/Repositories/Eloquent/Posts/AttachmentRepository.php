<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Exceptions\AttachmentNotFound;
use App\Models\Posts\Attachment;
use App\Repositories\Eloquent\BaseRepository;

class AttachmentRepository extends BaseRepository
{
    public function __construct(
        private readonly Attachment $attachment
    ) {
        parent::__construct($attachment);
    }

    public function createAttachment(array $attachmentData): Attachment
    {
        return $this->create($attachmentData);
    }

    public function deleteAttachment(Attachment $attachment): bool
    {
        $attachmentExists = $this->find($attachment->getKey());

        if (null === $attachmentExists) {
            throw new AttachmentNotFound();
        }

        return $attachment->delete();
    }

    public function findAttachmentViaChecksum(string $checksum): ?Attachment
    {
        return $this->getModel()->query()
            ->where('checksum', $checksum)
            ->first();
    }

    public function rename(string $newName): bool
    {
        /** @var Attachment $attachment */
        $attachment = $this->getModel();
        $previousName = $attachment->getFileName();

        $attachment->fileName = $newName;

        return $previousName !== $attachment->getFileName();
    }
}
