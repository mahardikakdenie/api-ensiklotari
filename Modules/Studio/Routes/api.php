<?php

use Illuminate\Http\Request;
use Modules\Studio\Http\Controllers\StudioController;

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

Route::middleware('auth:api')->get('/studio', function (Request $request) {
    return $request->user();
});

Route::prefix('studio')->group(function () {
    Route::get('', [StudioController::class, 'index']);
    Route::post('', [StudioController::class, 'store'])->middleware(['auth:sanctum']);
    Route::get('{slug}', [StudioController::class, 'showBySlug']);
});
