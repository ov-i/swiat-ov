<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Contracts\PubliclyAccessable;
use App\Data\CreateAttachmentRequest;
use App\Exceptions\FileOverSizedException;
use App\Exceptions\ForbiddenFileTypeException;
use App\Models\Posts\Attachment;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Services\UploadedFileService;
use Illuminate\Support\Number;
use App\Traits\IntersectsArray;

class AttachmentService extends UploadedFileService implements PubliclyAccessable
{
    use IntersectsArray;

    public function __construct(
        private readonly AttachmentRepository $attachmentRepository,
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        return 'attachments';
    }

    /**
     * @inheritDoc
     */
    public function getPublicUrl()
    {
        return asset("storage/{$this->getResource()}/{$this->getCurrentDate()}/{$this->getFileName()}");
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            ...parent::toArray(),
            'public_url' => $this->getPublicUrl()
        ];
    }

    /**
     * @inheritDoc
     */
    public function storeOnDisk(?string $disk = null): void
    {
        $this->setUploadDir($this->getCurrentDate());

        try {
            parent::storeOnDisk($disk);
        } catch (ForbiddenFileTypeException $forbiddenFileTypeException) {
            throw new ForbiddenFileTypeException($forbiddenFileTypeException->getMessage());
        } catch (FileOverSizedException $fileOverSizedException) {
            $maxSize = Number::fileSize(config('swiatov.max_file_size'));
            $uploadedFileSize = Number::fileSize($this->getFileSize());
            $originalName = $this->getOriginalName();

            throw new FileOverSizedException($originalName, $maxSize, $uploadedFileSize);
        }
    }

    public function createAttachment(CreateAttachmentRequest $request): Attachment|bool
    {
        $this->makeUploadDir();
        $file = $this->setFile($request->attachment);

        $file->setUploadDir($this->getCurrentDate())
            ->storeOnDisk();

        $fileInfo = $this->toArray();

        $attachment = $this->attachmentRepository->findAttachmentViaChecksum((string) $fileInfo['checksum']);

        if (filled($attachment)) {
            $toUpdate = $this->differences($attachment->toArray(), $fileInfo);

            return $this->attachmentRepository->updateAttachment(
                $attachment,
                updateData: $this->differences($attachment->toArray(), $toUpdate)
            );
        }

        $attachment = $this->attachmentRepository->createAttachment($fileInfo);

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
