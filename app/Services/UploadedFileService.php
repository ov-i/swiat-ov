<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Enums\Post\ThumbnailAllowedMimeTypesEnum;
use App\Exceptions\FileOverSizedException;
use App\Exceptions\ForbiddenFileTypeException;
use App\Jobs\StoreNewAttachmentJob;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Ramsey\Uuid\Uuid;

abstract class UploadedFileService implements Arrayable
{
    protected readonly FileSystem $fileSystem;

    private readonly string $storageResourcePath;

    private readonly string $fileHashAlgorithm;

    private readonly int $maxFileSize;

    private ?string $fileHash = null;

    private string $uploadDir;

    private ?UploadedFile $file = null;

    private string $fileName = '';

    private string $checksum = '';

    private string $mimeType = '';

    private string $originalName = '';

    private int $fileSize = 0;

    private string $fileExtension = '';

    protected function __construct()
    {
        $this->fileSystem = app(FileSystem::class);

        $this->storageResourcePath = storage_path("app/public");

        $this->fileHashAlgorithm = config('swiatov.file_hash_algo');

        $this->maxFileSize = config('swiatov.max_file_size');
    }

    /**
     * Gets resource name for which the file should be uploaded
     *
     * @return string
     */
    abstract public function getResource();

    /**
     * Get and set information about the file.
     */
    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        $hash = $this->hashFile($file);

        $this->setChecksum($hash);
        $this->setMimeType($file->getMimeType());
        $this->setOriginalName($file->getClientOriginalName());
        $this->setFileSize($file->getSize());
        $this->setFileExtension($file->getExtension());

        return $this;
    }

    /**
     * Gets file data if it has been set previously.
     *
     * @throws \Exception If file has not been set.
     */
    public function getContent(): UploadedFile
    {
        if(blank($this->file)) {
            throw new \Exception('File has not been set. Please use setFile method first.');
        }

        return $this->file;
    }

    /**
     * Gets the absolute location of a file. If byDate param is null, it gets current datetime
     */
    public function getFullLocation(?DateTime $byDate = null): string
    {
        if (blank($byDate)) {
            $byDate = $this->getCurrentDate();
        }

        return sprintf(
            '%s/%s/%s/%s',
            $this->getStoragePath(),
            $this->getResource(),
            $byDate,
            $this->getFileName()
        );
    }

    /**
     * Stores a new file with file size and mime type constraints on selected disk.
     *
     * @throws ForbiddenFileTypeException If mime type is not allowed.
     * @throws FileOverSizedException If file size > config('swiatov.max_file_size').
     */
    public function storeOnDisk(?string $disk = null): void
    {
        if (blank($disk)) {
            $disk = config('swiatov.storage_disk');
        }

        $mimeType = $this->getFileMimeType();
        $fileName = $this->createFileName()->getFileName();
        $dirPath = $this->getUploadDir();

        if (!$this->mimeTypeAllowed($mimeType)) {
            throw new ForbiddenFileTypeException("MimeType of {$mimeType} is forbidden.");
        }

        if ($this->fileOverSized()) {
            $maxSize = Number::fileSize($this->getMaxFileSize());
            $uploadedFileSize = Number::fileSize($this->getFileSize());
            $originalName = $this->getOriginalName();

            throw new FileOverSizedException($originalName, $maxSize, $uploadedFileSize);
        }

        $file = $this->getContent();

        dispatch(new StoreNewAttachmentJob($disk, $file->getRealPath(), $dirPath, $fileName));
    }

    /**
     * Deletes the file from storage.
     *
     * @return bool Returns false if file could not be deleted or not exists.
     */
    public function unlinkFile(string $fileName): bool
    {
        $path = "{$this->getRelativeLocation()}/{$fileName}";

        return is_file($path) ? $this->fileSystem->delete($path) : false;
    }

    public function getHashFile(): ?string
    {
        return $this->fileHash;
    }

    public function getCurrentDate(): string
    {
        return Carbon::now(timezone: config('app.timezone'))->format('Y_m_d');
    }

    public function mimeTypeAllowed(string $mimeType): bool
    {
        return
            in_array($mimeType, AttachmentAllowedMimeTypesEnum::toValues()) ||
            in_array($mimeType, ThumbnailAllowedMimeTypesEnum::toValues());
    }

    public function getStoragePath()
    {
        return $this->storageResourcePath;
    }

    public function getMaxFileSize()
    {
        return $this->maxFileSize;
    }

    public function getFileHashAlgorithm()
    {
        return $this->fileHashAlgorithm;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getChecksum()
    {
        return $this->checksum;
    }

    public function getFileMimeType()
    {
        return $this->mimeType;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    /**
     * Checks if file physically exists in the storage based on path.
     * If path is null, it gets a full storage location
     * @see getFullLocation()
     *
     * @return bool
     */
    public function fileExists(DateTime $fromDate, ?string $path = null): bool
    {
        if (blank($path)) {
            $path = $this->getFullLocation($fromDate);
            return $this->fileSystem->exists($path);
        }

        return $this->fileSystem->exists($path);
    }

    final public function setUploadDir(string $uploadDir): self
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    /**
     * @return array<string, scalar>
     */
    public function toArray()
    {
        return [
            'filename' => $this->getFileName(),
            'checksum' => $this->getChecksum(),
            'location' => $this->getFullLocation(),
            'mimetype' => $this->getFileMimeType(),
            'original_name' => $this->getOriginalName(),
            'size' => $this->getFileSize(),
        ];
    }

    /**
     * Creates file name based on original name and extension and UUID v4.
     */
    protected function createFileName(): self
    {
        $originalName = $this->getOriginalName();

        $fileName = sprintf('%s_%s_%s', $this->getCurrentDate(), Uuid::uuid4(), $originalName);

        $this->setFileName($fileName);

        return $this;
    }

    /**
     * Returns location from storage path and resource name.
     *
     * @example location app/public/attachments
     *
     * @return string
     */
    protected function getRelativeLocation(): string
    {
        return "{$this->getStoragePath()}/{$this->getResource()}";
    }

    protected function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    protected function setChecksum(string $checksum): self
    {
        $this->checksum = $checksum;

        return $this;
    }

    /**
     * Gets upload directory based on resource.
     */
    final protected function getUploadDir(): string
    {
        return sprintf('%s/%s', $this->getResource(), $this->uploadDir);
    }

    /**
     * Creates a new upload directory folder based on resource and date.
     * Current date is based on local timezone.
     *
     * @param int $mode An octal-written permissions.
     */
    final protected function makeUploadDir(int $mode = 0755): void
    {
        $dirPath = $this->getRelativeLocation();

        if (!is_dir($dirPath)) {
            $this->fileSystem->makeDirectory($dirPath, $mode, true);
        }
    }

    final protected function fileOverSized()
    {
        return $this->getFileSize() > $this->getMaxFileSize();
    }

    /**
     * @param int $fileSize
     *
     * @return $this
     */
    private function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * @param string $originalName
     *
     * @return $this
     */
    private function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    private function hashFile(UploadedFile &$file): string
    {
        return once(function () use (&$file) {
            $hash = $this->fileSystem->hash($file->getRealPath(), $this->fileHashAlgorithm);
            $this->fileHash = $hash;

            return $hash;
        });
    }

    private function setFileExtension(string $fileExtension): self
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    private function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }
}
