<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleTypeController;
use App\Http\Controllers\Api\SeatController;
use App\Http\Controllers\Api\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// VehicleTypeController
Route::get('/vehicle-types',[VehicleTypeController::class,'index']);
Route::get('/vehicles',[VehicleTypeController::class,'show']);
Route::post('/vehicle-types',[VehicleTypeController::class,'store']);

// SeatController
Route::post('/vehicles/{id}/seats', [SeatController::class,'generateAndStoreSeats']);

// BookingController
Route::post('/bookings', [BookingController::class,'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
