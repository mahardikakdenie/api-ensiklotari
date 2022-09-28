<?php

use Illuminate\Http\Request;
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

Route::prefix('live')->group(function() {
    Route::get('', [LiveController::class, 'index']);
    Route::post('', [LiveController::class, 'store']);
    Route::get('{id}', [LiveController::class, 'show']);
    Route::put('{id}', [LiveController::class, 'update']);
});