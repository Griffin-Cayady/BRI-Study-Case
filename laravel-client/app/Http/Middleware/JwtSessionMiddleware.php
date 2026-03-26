<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JwtSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('jwt_token')) {
            return redirect()->route('login')->withErrors([
                'login' => 'Please log in to continue.',
            ]);
        }

        return $next($request);
    }
}
