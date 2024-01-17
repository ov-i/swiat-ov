<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class CreateAttachmentRequest extends Data
{
    public function __construct(
        public readonly UploadedFile $attachment,
    ) {
    }
}
