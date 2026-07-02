<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        '/users',
        [\App\Http\Controllers\EmployeeController::class, 'getDataEmployee']
    );

    // Logout API
    Route::post(
        '/logout',
        [\App\Http\Controllers\AuthController::class, 'logout']
    );
});
