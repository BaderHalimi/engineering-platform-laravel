<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthManualMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->role=="user" and !$request->is('user/*')){
            return redirect(url('/user'));
        }else if(auth()->user()->role=="admin" and !$request->is('admin/*')){
            return redirect(url('/admin'));
        } else{
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
