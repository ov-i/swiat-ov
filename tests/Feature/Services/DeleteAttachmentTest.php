<?php

use App\Data\CreateAttachmentRequest;
use App\Services\Post\AttachmentService;
use Illuminate\Http\UploadedFile;

describe('Delete attachment test', function () {
    beforeEach(function () {
        $this->attachmentService = app(AttachmentService::class);
    });

    it('should be able to unlink the file from storage', function () {
        $uploadedFile = UploadedFile::fake()->create('avatar.png');
        $this->attachmentService->setFile($uploadedFile);

        $attachmentReq = new CreateAttachmentRequest(attachment: $uploadedFile);

        $attachment = $this->attachmentService->createAttachment($attachmentReq);

        expect($attachment)->not()->toBeNull();
        expect($attachment->filename)->not()->toBeNull();

        $deleted = $this->attachmentService->deleteAttachment($attachment);

        expect($deleted)->toBeTrue();
        expect($attachment->deleted_at)->not()->toBeNull();
        expect($attachment->deleted_at)->toEqual($attachment->deleted_at);
    });
});
