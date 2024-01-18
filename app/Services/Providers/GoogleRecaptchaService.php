<?php

declare(strict_types=1);

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class GoogleRecaptchaService
{
    public const GOOGLE_VERIFY_SITE = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Veiryfies the user's token, send by recaptcha api.
     * 
     * @param string $token User's token send by api
     * 
     * @return bool Returns false, if check was not successful.
     */
    public function verify(string $token): bool
    {
        $captchaRequest = Http::asForm()->post(self::GOOGLE_VERIFY_SITE, [
            'secret' => $this->getSecretKey(),
            'response' => $token,
            'remoteip' => Request::ip()
        ]);

        $response = json_decode($captchaRequest->body(), true);

        return $captchaRequest->successful() && $response['success'];
    }

    private function getSecretKey(): ?string
    {
        $key = config('swiatov.google_recaptcha_secret_key');

        return false === empty($key) ? $key : null;
    }
}
