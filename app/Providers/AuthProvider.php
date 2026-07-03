<?php

namespace App\Providers;

use App\Http\Services\AuthServices;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{
    /**
     * Register auth-related services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthServices::class, function ($app) {
            return new AuthServices();
        });
    }

    /**
     * Bootstrap auth-related services.
     */
    public function boot(): void
    {
        //
    }
}
