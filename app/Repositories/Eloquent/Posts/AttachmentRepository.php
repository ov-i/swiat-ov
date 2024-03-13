<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Posts;

use App\Exceptions\AttachmentNotFound;
use App\Models\Posts\Attachment;
use App\Repositories\Eloquent\BaseRepository;

class AttachmentRepository extends BaseRepository
{
    /**
     * @param non-empty-list<array-key, mixed> $attachmentData
     *
     * @return Attachment|bool
     */
    public function createAttachment(array $attachmentData)
    {
        return $this->create($attachmentData);
    }

    /**
     * @param non-empty-list<array-key, mixed> $updateData
     *
     * @return bool
     */
    public function updateAttachment(Attachment &$attachment, array $updateData, bool $onlyDirty = false)
    {
        if ($onlyDirty) {
            return $this->updateDirty($attachment);
        }

        return $this->update($attachment, $updateData);
    }

    /**
     * @param Attachment $attachment
     * @param bool $forceDelete
     *
     * @throws AttachmentNotFound
     * @return bool
     */
    public function deleteAttachment(Attachment &$attachment, bool $forceDelete = false)
    {
        $attachmentExists = $this->find($attachment->getKey());

        if (null === $attachmentExists) {
            throw new AttachmentNotFound();
        }

        return $this->delete($attachment, $forceDelete);
    }

    public function findAttachmentViaChecksum(string $checksum): ?Attachment
    {
        return $this->findBy('checksum', $checksum);
    }

    public function rename(string $newName): bool
    {
        /** @var Attachment $attachment */
        $attachment = $this->getModel();
        $previousName = $attachment->getFileName();

        $attachment->fileName = $newName;

        return $previousName !== $attachment->getFileName();
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return Attachment::class;
    }
}
