<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Exceptions\FileOverSizedException;
use App\Exceptions\ForbiddenFileTypeException;
use App\Jobs\StoreNewAttachmentJob;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

abstract class UploadedFileService implements Arrayable
{
    private readonly string $storageResourcePath;

    private readonly FileSystem $fileSystem;

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
        $hash = $this->fileSystem->hash($file, config('swiatov.file_hash_algo'));

        $this->setChecksum($hash);
        $this->setMimeType($file->getMimeType());
        $this->setOriginalName($file->getClientOriginalName());
        $this->setFileSize($file->getSize());
        $this->setFileExtension($file->getExtension());

        return $this;
    }

    public function getRelativeStorePath(): string
    {
        return sprintf('%s', $this->getResource());
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
            $this->getRelativeStorePath(),
            $byDate,
            $this->getFileName()
        );
    }

    public function getRelativeLocation(): string
    {
        $storePath = "{$this->getStoragePath()}/{$this->getRelativeStorePath()}";

        return sprintf('%s/%s', $storePath, $this->getCurrentDate());
    }

    /**
     * Creates file name based on original name and extension and UUID v4.
     *
     * @return $this
     */
    public function createFileName(): self
    {
        $originalName = $this->getOriginalName();
        $checksum = $this->getChecksum();

        $fileName = sprintf('%s_%s_%s', $this->getCurrentDate(), $checksum, $originalName);

        $this->setFileName($fileName);

        return $this;
    }

    /**
     * Stores a new file with file size and mime type constraints on selected disk.
     * Moreover, any uploaded file, is going to be saved as base64.
     *
     * @param string $disk Default: public
     *
     * @return void
     */
    public function storeOnDisk(string $disk = 'public'): void
    {
        $this->makeUploadDirWithDate();
        $mimeType = $this->getFileMimeType();
        $fileName = $this->createFileName()->getFileName();

        $dirPath = sprintf('%s/%s/', $this->getRelativeStorePath(), $this->getCurrentDate());

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

        if (false === app()->environment('testing')) {
            dispatch(new StoreNewAttachmentJob($disk, $file, $dirPath, $fileName));
        }

        Storage::disk($disk)->putFileAs($dirPath, $file, $fileName);
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
        return in_array($mimeType, AttachmentAllowedMimeTypesEnum::toValues());
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


    public function toArray(): array
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
     * Creates new upload directory folder based on resource and date.
     * Current date is based on local timezone.
     *
     * @param int $mode An octal-written permissions
     *
     * @return void
     */
    protected function makeUploadDirWithDate(int $mode = 0755): void
    {
        $dirPath = $this->getRelativeLocation();

        if (false === is_dir($dirPath)) {
            $this->fileSystem->makeDirectory($dirPath, $mode, true);
        }
    }

    protected function fileOverSized(): bool
    {
        return $this->getFileSize() > config('swiatov.max_file_size');
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
