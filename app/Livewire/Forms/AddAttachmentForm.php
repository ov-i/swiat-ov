<?php

namespace App\Livewire\Forms;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddAttachmentForm extends Form
{
    /** @var array<array-key, \Illuminate\Http\UploadedFile> $attachments */
    public array $attachments = [];

    /**
     * @return non-empty-list<string, array<array-key, mixed>>
     */
    public function rules(): array
    {
        $allowedAttachments = AttachmentAllowedMimeTypesEnum::toLabels();
        return [
            'attachments.*' => [
                'required',
                sprintf('mimetypes:%s', implode(',', AttachmentAllowedMimeTypesEnum::toValues())),
                Rule::file()
                    ->extensions([...$allowedAttachments])
                    ->max(config('swiatov.max_file_size'))
            ]
        ];
    }
}
