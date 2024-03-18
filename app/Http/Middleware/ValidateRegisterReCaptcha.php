<?php

namespace App\Http\Middleware;

use App\Services\Providers\GoogleRecaptchaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateRegisterReCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getBasePath() === '/register' && $request->isMethod(Request::METHOD_POST)) {
            $googleRecaptcha = new GoogleRecaptchaService();

            $token = $request['g-recaptcha-response'];

            $captchaVerified = $googleRecaptcha->verify($token);

            if (false === $captchaVerified) {
                return redirect()->back()->with('invalid_captcha', 'Invalid captcha');
            }
        }

        return $next($request);
    }
}
