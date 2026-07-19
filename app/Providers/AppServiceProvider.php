<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    public function boot(): void {
        // Keyed by user_id from the request body, not IP: this endpoint is only
        // reachable via the 'private' service-to-service call from notification-server,
        // so every request shares that one IP regardless of which account is targeted.
        RateLimiter::for('telegram-link', function ($request) {
            return Limit::perSecond(5, 120)->by($request->input('user_id'));
        });
    }
}
