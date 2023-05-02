<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\V1\Auth\ProfileController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\ParkingController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\ZoneController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('password', PasswordUpdateController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('parkings/start', [ParkingController::class, 'start']);
    Route::get('parkings/{parking}', [ParkingController::class, 'show'])->whereNumber('parking');
    Route::put('parkings/{parking}', [ParkingController::class, 'stop'])->whereNumber('parking');
    Route::post('auth/logout', LogoutController::class);
});

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
});

Route::get('zones', [ZoneController::class, 'index']);
