<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SupervisorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('supervisor')) {
            return redirect('/supervisor/login');
        }

        return $next($request);
    }
}