<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;


class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (config('app.env') === 'production' || request()->isSecure()) {
            URL::forceScheme('https');
        }

        RateLimiter::for('chat-send', function (Request $request) {
            $key = optional($request->user())->id ?: $request->ip();

            return Limit::perMinute(20)->by($key)->response(function (Request $request, array $headers) {
                return response()->json([
                    'error' => 'You are sending messages too quickly. Please slow down.',
                ], 429, $headers);
            });
        });
    }
}