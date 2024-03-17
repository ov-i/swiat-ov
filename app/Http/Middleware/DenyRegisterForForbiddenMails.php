<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DenyRegisterForForbiddenMails
{
    private array $forbiddens = [
        'admin',
        'user',
        'root',
        'moderator',
        'subject',
        'test'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getPathInfo() === '/register' && $request->isMethod(Request::METHOD_POST)) {
            $email = $request->email;
            $name = $request->name;

            $this->rejectUsersWithForbiddenMailOrUsername($email, $name);
        }

        return $next($request);
    }


    private function rejectUsersWithForbiddenMailOrUsername(string $email, string $name): void
    {
        foreach ($this->forbiddens as $forbidden) {
            if (
                true === str_contains(strtolower($email), $forbidden) ||
                true === str_contains(strtolower($name), $forbidden)
            ) {
                abort(Response::HTTP_FORBIDDEN);
            }
        }
    }
}
