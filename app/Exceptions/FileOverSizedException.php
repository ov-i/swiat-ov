<?php

namespace App\Exceptions;

use Exception;

class FileOverSizedException extends Exception
{
    public function __construct(
        private readonly string $originalName,
        private readonly string $maxSize,
        private readonly string $uploadedFileSize
    ) {
        $message = "The file [{$originalName}] is too large. Max size is {$maxSize}, you uploaded {$uploadedFileSize}";
        parent::__construct(__($message));
    }
}
