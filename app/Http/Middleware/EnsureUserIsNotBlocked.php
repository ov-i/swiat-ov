<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotBlocked
{
    public function __construct(
        private readonly AuthRepository $authRepository,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            /** @var User $user */
            $user = auth()->user();

            if (true === $user->isBlocked()) {
                auth()->guard('web')->logout();

                $duration = sprintf(
                    '<br /><strong class="text-red-500">%s</strong>',
                    $this->authRepository->blockedUntil($user)
                );
                
                return redirect()
                    ->route('login')
                    ->with('block',__('auth.blocked', [
                                'duration' => $duration,
                                'user' => $user->name,
                            ]
                        ));
            }
        }

        return $next($request);
    }
}
