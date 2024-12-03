<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckJwtToken
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Cookie::has('jwt_token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
