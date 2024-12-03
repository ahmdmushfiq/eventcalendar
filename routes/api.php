<?php

use App\Http\Controllers\Api\CalenderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('event-create', [CalenderController::class, 'eventCreate']);
Route::post('event-update', [CalenderController::class, 'eventUpdate']);
Route::post('event-delete', [CalenderController::class, 'eventDelete']);