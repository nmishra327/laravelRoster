<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Event routes
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/upcoming-flights', [EventController::class, 'upcomingFlights']);
Route::get('/events/upcoming-standby', [EventController::class, 'upcomingStandby']);
Route::get('/events/flights-from-location', [EventController::class, 'flightsFromLocation']);
Route::post('/events/upload-roster', [EventController::class, 'uploadRoster']);
