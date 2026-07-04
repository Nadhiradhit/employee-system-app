<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\EmployeeController;
use App\Http\Controllers\web\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth:sanctum')->group(function () {

    // Admin dashboard (requires is_admin)
    Route::prefix('dashboard-admin')->group(function () {
        Route::middleware('is_admin')->group(function () {
            Route::get('/', [DashboardController::class, 'admin'])->name('admin.dashboard');
        });
    });

    // User dashboard
    Route::prefix('dashboard-user')->group(function () {
        Route::get('/', [DashboardController::class, 'user'])->name('user.dashboard');
    });

    // User management — admin only (full CRUD)
    Route::prefix('users')->name('users.')->middleware('is_admin')->group(function () {
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Employee CRUD — read open to both roles, writes admin-only
    Route::prefix('employees')->name('employees.')->group(function () {
        // Write — admin only (create route must be before {user_id} wildcard)
        Route::middleware('is_admin')->group(function () {
            Route::get('/create', [EmployeeController::class, 'create'])->name('create');
            Route::post('/', [EmployeeController::class, 'store'])->name('store');
            Route::get('/{user_id}/edit', [EmployeeController::class, 'edit'])->name('edit');
            Route::put('/{user_id}', [EmployeeController::class, 'update'])->name('update');
            Route::delete('/{user_id}', [EmployeeController::class, 'destroy'])->name('destroy');
        });

        // Read — available to both admin and user
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/{user_id}', [EmployeeController::class, 'show'])->name('show');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/register', [AuthController::class, 'register'])->name('register');
