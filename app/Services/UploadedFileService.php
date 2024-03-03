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
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Ramsey\Uuid\Uuid;

abstract class UploadedFileService implements Arrayable
{
    protected readonly FileSystem $fileSystem;

    private string $uploadDir;

    private readonly string $storageResourcePath;

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
    }

    /**
     * Gets resource name for which the file should be uploaded
     *
     * @return string
     */
    abstract public function getResource(): string;

    /**
     * Gets file data if it has been set previously.
     *
     * @return UploadedFile Aborts with Http not found if file not set
     */
    public function getContent(): UploadedFile
    {
        if(null === $this->file) {
            abort(Response::HTTP_NOT_FOUND, 'File has not been set. Please use setFile method first.');
        }

        return $this->file;
    }

    /**
     * Get and set information about the file.
     *
     * @return $this
     */
    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        $hash = $this->fileSystem->hash($file->getRealPath(), config('swiatov.file_hash_algo'));

        $this->setChecksum($hash);
        $this->setMimeType($file->getMimeType());
        $this->setOriginalName($file->getClientOriginalName());
        $this->setFileSize($file->getSize());
        $this->setFileExtension($file->getExtension());

        return $this;
    }

    /**
     * Gets the absolute location of a file. If byDate param is null, it gets current datetime
     *
     * @param ?DateTime $byDate
     *
     * @return string
     */
    public function getFullLocation(?DateTime $byDate = null): string
    {
        if (null === $byDate) {
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
     * Creates file name based on original name and extension and UUID v4.
     *
     * @return $this
     */
    public function createFileName(): self
    {
        $originalName = $this->getOriginalName();

        $fileName = sprintf('%s_%s_%s', $this->getCurrentDate(), Uuid::uuid4(), $originalName);

        $this->setFileName($fileName);

        return $this;
    }

    /**
     * Stores a new file with file size and mime type constraints on selected disk.
     * Moreover, any uploaded file, is going to be saved as base64.
     *
     * @param ?string $uploadDir stores file in Resource folder if null, uploadDir otherwise.
     * @param string $disk Default: public
     *
     * @return void
     */
    public function storeOnDisk(string $disk = 'public'): void
    {
        $mimeType = $this->getFileMimeType();
        $fileName = $this->createFileName()->getFileName();

        $dirPath = $this->getUploadDir();

        if (false === $this->mimeTypeAllowed($mimeType)) {
            throw new ForbiddenFileTypeException("MimeType of {$mimeType} is forbidden.");
        }

        if (true === $this->fileOverSized()) {
            $maxSize = Number::fileSize(config('swiatov.max_file_size'));
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

    public function getCurrentDate(): string
    {
        return Carbon::now(tz: config('app.timezone'))->format('Y_m_d');
    }

    public function mimeTypeAllowed(string $mimeType): bool
    {
        return
            in_array($mimeType, AttachmentAllowedMimeTypesEnum::toValues()) ||
            in_array($mimeType, ThumbnailAllowedMimeTypesEnum::toValues());
    }

    public function getStoragePath(): string
    {
        return $this->storageResourcePath;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getChecksum(): string
    {
        return $this->checksum;
    }

    public function getFileMimeType(): ?string
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
     * @param DateTime $fromDate Deterimates the directory to lookup.
     * @param ?string $path
     *
     * @return bool
     */
    public function fileExists(DateTime $fromDate, ?string $path = null): bool
    {
        if (null === $path) {
            $path = $this->getFullLocation($fromDate);
            return $this->fileSystem->exists($path);
        }

        return $this->fileSystem->exists($path);
    }

    public function getPublicUrl(): string
    {
        return asset("storage/{$this->getUploadDir()}/{$this->getFileName()}");
    }

    final public function setUploadDir(string $uploadDir): self
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'filename' => $this->getFileName(),
            'checksum' => $this->getChecksum(),
            'location' => $this->getFullLocation(),
            'mimetype' => $this->getFileMimeType(),
            'original_name' => $this->getOriginalName(),
            'size' => $this->getFileSize(),
            'public_url' => $this->getPublicUrl()
        ];
    }

    /**
     * Gets upload dir with Resource path
     */
    final protected function getUploadDir(): string
    {
        return sprintf('%s/%s', $this->getResource(), $this->uploadDir);
    }

    /**
     * Creates new upload directory folder based on resource and date.
     * Current date is based on local timezone.
     *
     * @param int $mode An octal-written permissions
     *
     * @return void
     */
    final protected function makeUploadDir(int $mode = 0755): void
    {
        $dirPath = $this->getRelativeLocation();

        if (false === is_dir($dirPath)) {
            $this->fileSystem->makeDirectory($dirPath, $mode, true);
        }
    }

    final protected function fileOverSized(): bool
    {
        return $this->getFileSize() > config('swiatov.max_file_size');
    }

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

    private function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    private function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
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
