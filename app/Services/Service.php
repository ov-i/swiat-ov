<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class Service
{
    /**
     * Gets currently logged in user
     *
     * @throws BindingResolutionException
     */
    public function getUser(): ?Authenticatable
    {
        return auth()->user();
    }
}
