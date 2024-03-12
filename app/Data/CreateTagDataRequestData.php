<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class CreateTagDataRequestData extends Data
{
    public function __construct(
        #[Required, Unique(table: 'tags', column: 'name')]
        public readonly string $name
    ) {
    }
}
