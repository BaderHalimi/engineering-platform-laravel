<?php

namespace App\Http\Middleware;

use App\Models\Setup;
use Closure;
use Illuminate\Http\Request;

class CheckSiteMaintenance
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin*')) {
            return $next($request);
        }

        $isActive = Setup::get('site_active', '1');

        if (!$isActive || $isActive === '0') {
            $message = Setup::get('maintenance_message', 'الموقع تحت الصيانة حالياً.');
            return response()->view('maintenance', [
                'message' => $message,
            ], 503);
        }

        return $next($request);
    }
}
