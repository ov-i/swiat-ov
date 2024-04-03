<?php

namespace App\Data;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class CreateAttachmentRequest extends Data
{
    public function __construct(
        public readonly UploadedFile $attachment,
    ) {
    }

    public static function rules(): array
    {
        $allowedAttachments = AttachmentAllowedMimeTypesEnum::toLabels();

        return [
            'attachment' => [
                'required',
                sprintf('mimetypes:%s', implode(',', AttachmentAllowedMimeTypesEnum::toValues())),
                Rule::file()
                    ->extensions($allowedAttachments)
                    ->max(config('swiatov.max_file_size'))
            ]
        ];
    }
}
