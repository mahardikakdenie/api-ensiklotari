<?php

use Illuminate\Http\Request;
use Modules\Dashboard\Http\Controllers\BannerController;

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

// Route::middleware('auth:api')->get('/dashboard', function (Request $request) {
//     return $request->user();
// });

Route::prefix("dashboard")->middleware(['auth:sanctum'])->group(function() {
    Route::prefix("banners")->group(function() {
        Route::get("", [BannerController::class, 'index']);
        Route::post("", [BannerController::class, 'setManageBanner']);
    });
});