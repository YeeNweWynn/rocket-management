<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RocketController;
use App\Http\Controllers\WeatherController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/rocket-overview', [RocketController::class, 'getOverviewData']);
Route::get('/weather', [WeatherController::class, 'getWeatherData']);
Route::put('/rocket/{id}/status/launched', [RocketController::class, 'updateRocketStatus']);