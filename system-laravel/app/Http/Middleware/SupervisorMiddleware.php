<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SupervisorMiddleware
{
    public function handle(Request $request, Closure $next)
{
    if (!session('supervisor')) {

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired',
                'redirect' => '/landing'
            ], 401);
        }

        return redirect('/landing');
    }

    return $next($request);
}
}