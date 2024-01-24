<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RestrictRoutes
{
    public function handle($request, Closure $next)
    {
        // Allow access to the login route
        if ($request->is('login') || $request->is('login/*')) {
            return $next($request);
        }

        // Deny access to other routes for unauthenticated users
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
