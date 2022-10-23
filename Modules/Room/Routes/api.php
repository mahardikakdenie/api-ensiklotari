<?php

use Illuminate\Http\Request;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\HomePage\Http\Controllers\HomePageController;
use Modules\Room\Http\Controllers\LiveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/room', function (Request $request) {
    return $request->user();
});

Route::prefix('live')->middleware(["auth:sanctum"])->group(function() {
    Route::get('', [LiveController::class, 'index']);
    Route::post('', [LiveController::class, 'store']);
    Route::get('{id}', [LiveController::class, 'show']);
    Route::put('{id}', [LiveController::class, 'update']);
});

Route::prefix("dashboard")->middleware("auth:sanctum")->group(function() {
    Route::prefix("banner")->group(function() {
        Route::get("", [DashboardController::class,'index']);
        Route::post("", [DashboardController::class,'storeBanner']);
    });
});