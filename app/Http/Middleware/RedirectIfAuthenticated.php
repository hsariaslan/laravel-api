<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Cookie::has('jwt_token')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
