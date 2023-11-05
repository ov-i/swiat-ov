<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

abstract class Action
{
    /**
     * Executes an action
     *
     * @param Data $requestData
     * @return Model|null
     */
    abstract public function execute(Data $requestData): ?Model;
}
