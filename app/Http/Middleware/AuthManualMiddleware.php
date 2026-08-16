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
        if(auth()->user()->role=="user"){
            if(!($request->is('user/*') || $request->is('user'))){
                return redirect(url('/user'));
            }else{
                return $next($request);
            }
        }else if(auth()->user()->role=="admin"){
            if(!($request->is('admin/*') || $request->is('admin'))){
                return redirect(url('/admin'));
            }else{
                return $next($request);
            }
        } else{
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
