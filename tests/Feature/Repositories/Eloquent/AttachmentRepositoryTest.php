<?php

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Models\Posts\Attachment;
use App\Models\User;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

describe('Attachment Repository', function () {
    beforeEach(function () {
        $this->attachmentRepository = new AttachmentRepository();
    });

    it('should be able to create attachment record', function (User $user) {
        $mimeType = AttachmentAllowedMimeTypesEnum::pdf()->value;
        $attachmentFile = UploadedFile::fake()->create('attachment.pdf', mimeType: $mimeType);

        $attachment = $this->attachmentRepository->createAttachment([
            'user_id' => $user->getKey(),
            'original_name' => $attachmentFile->getClientOriginalName(),
            'filename' => fake()->realText(10),
            'checksum' => hash(config('swiatov.file_hash_algo'), 'checksum'),
            'size' => $attachmentFile->getSize(),
            'mimetype' => $attachmentFile->getMimeType(),
            'location' => 'somewhere',
        ]);

        expect($attachment)->toBeInstanceOf(Attachment::class);
        expect($attachment->getMimeType())->toBe($mimeType);
    })->with('custom-user');

    it('should be able to update attachment data', function () {
        $attachment = Attachment::factory()->create();

        $updated = $this->attachmentRepository->updateAttachment($attachment, ['original_name' => 'changed.txt']);

        expect($updated)->toBeTrue();
    });

    it('should be able to update just dirty-stated properties', function () {
        $attachment = Attachment::factory()->create();
        $attachment->original_name = "changed.txt";

        $updated = $this->attachmentRepository->updateAttachment($attachment, onlyDirty: true);

        expect($updated)->toBeTrue();
    });

    it('should be able to delete attachment', function () {
        $attachment = Attachment::factory()->create();

        $deleted = $this->attachmentRepository->deleteAttachment($attachment);

        expect($deleted)->toBeTrue();
        expect($deleted)->not()->toBeNull();
        expect($attachment->fresh()->trashed())->toBeTrue();
    });

    it('should be able to force delete attachment', function () {
        $attachment = Attachment::factory()->create();

        $deleted = $this->attachmentRepository->deleteAttachment($attachment, forceDelete: true);

        expect($deleted)->toBeTrue();
        expect($attachment->fresh())->toBeNull();
    });

    it('should be able to find attachment via it\'s checksum', function () {
        $attachment = Attachment::factory()->create();

        $found = $this->attachmentRepository->findAttachmentViaChecksum($attachment->getChecksum());

        expect($found)->toBeInstanceOf(Attachment::class);
        expect($found->getOriginalName())->toEqual($attachment->getOriginalName());
    });

    it('should be able to rename the file name', function () {
        $attachment = Attachment::factory()->create();

        $renamed = $this->attachmentRepository->rename($attachment, newName: 'otherName');

        expect($renamed)->toBeTrue();
        expect($attachment->fresh()->getFileName())->not()->toEqual($attachment->getFileName());
    });
});
