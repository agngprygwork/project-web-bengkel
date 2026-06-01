<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MekanikMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'mekanik') {
            abort(403, 'Unauthorized access. Mekanik only.');
        }
        return $next($request);
    }
}
