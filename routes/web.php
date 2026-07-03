<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth:sanctum')->group(function () {

    // Admin dashboard (requires is_admin)
    Route::prefix('dashboard-admin')->group(function () {
        Route::middleware('is_admin')->group(function () {
            Route::get('/', [DashboardController::class, 'admin'])->name('admin.dashboard');
        });

        // Regular user dashboard (any authenticated user)
        Route::get('/user', [DashboardController::class, 'user'])->name('user.dashboard');
    });

    // Logout (POST for CSRF protection)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/register', [AuthController::class, 'register'])->name('register');
