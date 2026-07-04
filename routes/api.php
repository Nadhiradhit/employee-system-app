<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['middleware' => 'is_admin'], function () {

        // Employee API

        Route::post(
            '/employees',
            [EmployeeController::class, 'create']
        );

        Route::put(
            '/employees/{id}',
            [EmployeeController::class, 'update']
        );

        Route::delete(
            '/employees/{id}',
            [EmployeeController::class, 'delete']
        );
    });

    Route::get(
        '/employees',
        [EmployeeController::class, 'get']
    );

    Route::get(
        '/employees/{id}',
        [EmployeeController::class, 'detail']
    );

    // Logout API
    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    );
});
