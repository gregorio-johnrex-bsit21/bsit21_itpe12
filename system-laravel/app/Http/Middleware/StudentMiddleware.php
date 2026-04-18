<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('student')) {
            // Check if request expects JSON
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