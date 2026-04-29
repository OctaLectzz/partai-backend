<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouncilController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\IndoRegionController;
use App\Http\Controllers\MassaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Regions
Route::prefix('regions')->controller(IndoRegionController::class)->group(function () {
    Route::get('/provinces', 'provinces');
    Route::get('/regencies/{province_id}', 'regencies');
    Route::get('/districts/{regency_id}', 'districts');
    Route::get('/villages/{district_id}', 'villages');
});

// Event Registration
Route::post('/events/{event:slug}/register', [EventParticipantController::class, 'store']);

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

// Dashboard
Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::apiResource('users', UserController::class);

    // Category
    Route::apiResource('categories', CategoryController::class);

    // Event
    Route::apiResource('events', EventController::class);
    Route::get('events/{event:slug}/participants', [EventParticipantController::class, 'index']);
    Route::patch('events/{event:slug}/participants/{participant}', [EventParticipantController::class, 'updateStatus']);
    Route::post('/events/{event:slug}/participants/scan/{participantCode}', [EventParticipantController::class, 'scanQr']);

    // Massa
    Route::apiResource('massas', MassaController::class);

    // Council
    Route::apiResource('councils', CouncilController::class);
});
