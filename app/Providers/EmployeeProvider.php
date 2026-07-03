<?php

namespace App\Providers;

use App\Http\Services\EmployeeServices;
use Illuminate\Support\ServiceProvider;

class EmployeeProvider extends ServiceProvider
{
    /**
     * Register employee-related services.
     */
    public function register(): void
    {
        $this->app->singleton(EmployeeServices::class, function ($app) {
            return new EmployeeServices();
        });
    }

    /**
     * Bootstrap employee-related services.
     */
    public function boot(): void
    {
        //
    }
}
