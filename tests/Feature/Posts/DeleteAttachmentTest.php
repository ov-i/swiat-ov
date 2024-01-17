<?php

use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Services\Post\AttachmentService;
use Illuminate\Http\UploadedFile;

describe('Delete attachment test', function () {
    beforeEach(function () {
        $attachmentRepository = app(AttachmentRepository::class);

        $this->attachmentService = new AttachmentService($attachmentRepository);
    });

    it('should be able to unlink the file from storage', function () {
        $uploadedFile = UploadedFile::fake()->create('avatar.png');
        $this->attachmentService->setFile($uploadedFile)
            ->createFileName();

        $attachment = $this->attachmentService->createAttachment(['attachment' => $uploadedFile]);

        expect($attachment)->not()->toBeNull();
        expect($attachment->filename)->not()->toBeNull();

        $deleted = $this->attachmentService->deleteAttachment($attachment);

        expect($deleted)->toBeTrue();
        expect($attachment->deleted_at)->not()->toBeNull();
        expect($attachment->deleted_at)->toEqual($attachment->deleted_at);
    });
});
