<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            auth()->check() &&
            auth()->user()->email_verified_at === null &&
            !$request->routeIs([
                'verification.notice',
                'verification.verify',
                'verification.resend',
                'logout',
            ])
        ) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
