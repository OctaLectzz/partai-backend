<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/profile', 'profile');
        Route::put('/profile/edit', 'editprofile');
        Route::post('/profile/changepassword', 'changepassword');
    });
});

// User
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});
