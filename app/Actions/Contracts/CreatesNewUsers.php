<?php

namespace App\Actions\Contracts;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

interface CreatesNewUsers extends \Laravel\Fortify\Contracts\CreatesNewUsers
{
    public function execute(Data $requestData): Model;
}
