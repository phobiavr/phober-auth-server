<?php

namespace App\Providers;

use Abdukhaligov\LaravelOTP\Otp;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        Otp::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
