<?php

namespace App\Contracts;

interface PubliclyAccessable
{
    /**
     * Creates publicly accessable url, that can be used in the application's frontend.
     *
     * @return string
     */
    public function getPublicUrl();
}
