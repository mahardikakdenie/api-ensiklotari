<?php

use Illuminate\Http\Request;
use Modules\Media\Http\Controllers\MediaController;

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

Route::middleware('auth:api')->get('/media', function (Request $request) {
    return $request->user();
});

Route::prefix("media")->group(function () {
    Route::post('', [MediaController::class, 'store']);
});