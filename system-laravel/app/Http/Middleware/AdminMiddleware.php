<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!session('admin')) {

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'redirect' => '/login'
            ], 401);
        }

        return redirect('/login');
    }

    return $next($request);
}
}
