<?php

use App\Http\Controllers\EventParticipantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets/{participantCode}/download', [EventParticipantController::class, 'downloadTicket'])->name('tickets.download');
