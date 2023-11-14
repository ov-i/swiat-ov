<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// TODO: Implement Localizable model based on translations
abstract class LocalizableModel extends Model
{
    public function __get($key)
    {
        //
    }
}
