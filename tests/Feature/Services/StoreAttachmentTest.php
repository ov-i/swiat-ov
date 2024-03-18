<?php

use App\Data\CreateAttachmentRequest;
use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Services\Post\AttachmentService;
use App\Services\UploadedFileService;
use Illuminate\Http\UploadedFile;

describe('Store attachment test', function () {
    beforeEach(function () {
        $this->attachmentService = app(AttachmentService::class);
    });

    it('must have storage path set', function () {
        $storagePath = $this->attachmentService->getStoragePath();

        expect($storagePath)->not()->toBeNull();
        expect($storagePath)->toBeString(storage_path('app/public'));
    });

    it('must have resource defined', function () {
        $resource = $this->attachmentService->getResource();

        expect($resource)->not()->toBeNull();
        expect($resource)->toBeString('attachments');
    });

    it('must have resource based store path defined', function () {
        $fileStorePath = $this->attachmentService->getFullLocation();

        expect($fileStorePath)->toBeString();
        expect($fileStorePath)->toContain('attachments');
        expect($fileStorePath)->not()->toBeNull();
    });

    it('must be able to set file content', function () {
        $file = UploadedFile::fake()->create('invoice.jpg', 1000, 'image/jpeg');
        $file = $this->attachmentService->setFile($file)->getContent();

        expect($file)->toBeInstanceOf(UploadedFile::class);
        expect($file->getClientOriginalName())->toBeString('invoice.jpg');
        expect($file->getSize())->toBeGreaterThanOrEqual(1_000_000);
    });

    it('must be able to create file name from uploaded file', function () {
        $file = UploadedFile::fake()->create('invoice.jpg', 1000, 'image/jpeg');
        /** @var AttachmentService $storedFile */
        $storedFile = $this->attachmentService->setFile($file);

        $storedFile->storeOnDisk();

        expect($storedFile->getFileName())->not()->toBeNull();
        expect($storedFile->getFileName())->toBeString();
        expect($storedFile->getChecksum())->toContain($storedFile->getHashFile());
        expect($storedFile->getFileName())->toContain('.jpg');
    });

    it('should test allowed mime types', function (AttachmentAllowedMimeTypesEnum $mimeType) {
        $allowed = $this->attachmentService->mimeTypeAllowed($mimeType->value);

        expect($allowed)->toBeTrue();
    })->with('allowed_mime_types');

    it('should test NOT allowed mime types', function () {
        $allowed = $this->attachmentService->mimeTypeAllowed('application/json');
        expect($allowed)->toBeFalse();
    });

    it('must be able to store file locally', function () {
        $file = UploadedFile::fake()->create('file.txt', 120);

        /** @var UploadedFileService $fileService */
        $fileService = $this->attachmentService->setFile($file);

        $fileService->storeOnDisk();

        expect($fileService->getFileName())->not()->toBeNull();
        expect($fileService->getChecksum())->toBeString();
    });

    it('must be able to save attachment info into database', function () {
        $file = UploadedFile::fake()->create('file2.txt', 120);

        /** @var AttachmentService $fileService */
        $fileService = $this->attachmentService->setFile($file);

        $request = new CreateAttachmentRequest($file);
        $attachment = $fileService->createAttachment($request);

        expect($attachment)->not()->toBeNull();
    });
});
