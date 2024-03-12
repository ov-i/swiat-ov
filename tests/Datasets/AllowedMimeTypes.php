<?php

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;

dataset('allowed_mime_types', function () {
    return AttachmentAllowedMimeTypesEnum::cases();
});
