<?php

namespace App\Providers;

use App\Http\Repositories\UserRepository;
use App\Http\Services\AuthServices;
use App\Http\Services\UserService;
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

        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(
                $app->make(UserRepository::class)
            );
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
