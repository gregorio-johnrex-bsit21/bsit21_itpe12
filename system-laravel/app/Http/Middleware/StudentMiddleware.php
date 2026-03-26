<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('student')) {
            return redirect('/landing');
        }

        return $next($request);
    }
}