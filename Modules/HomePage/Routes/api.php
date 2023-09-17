<?php

use Illuminate\Http\Request;
use Modules\HomePage\Http\Controllers\HomePageController;

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

Route::middleware('auth:api')->get('/homepage', function (Request $request) {
    return $request->user();
});

Route::prefix("home-page")->middleware(['auth:sanctum'])->group(function () {
    Route::prefix("banners")->group(function () {
        Route::get("", [HomePageController::class, 'index']);
        Route::post("", [HomePageController::class, 'setManageBanner']);
    });
});
