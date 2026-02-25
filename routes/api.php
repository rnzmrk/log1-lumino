<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\PoController;
use App\Http\Controllers\Api\RequestController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Vehicle API Routes
Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
});

// Purchase Order API Routes
Route::prefix('po')->group(function () {
    Route::get('/', [PoController::class, 'index']);
});

// Request API Routes
Route::prefix('request')->group(function () {
    Route::get('/', [RequestController::class, 'index']);
});
