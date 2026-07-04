<?php

namespace App\Providers;

use App\Http\Repositories\EmployeeRepository;
use App\Http\Services\EmployeeService;
use App\Http\Services\EmployeeServices;
use Illuminate\Support\ServiceProvider;

class EmployeeProvider extends ServiceProvider
{
    /**
     * Register employee-related services.
     */
    public function register(): void
    {
        $this->app->singleton(EmployeeRepository::class, function ($app) {
            return new EmployeeRepository();
        });

        $this->app->singleton(EmployeeService::class, function ($app) {
            return new EmployeeService(
                $app->make(EmployeeRepository::class)
            );
        });

        // Keep old service for API backward compatibility
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
