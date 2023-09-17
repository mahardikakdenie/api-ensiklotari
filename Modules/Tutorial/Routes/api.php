<?php

use Illuminate\Http\Request;
use Modules\Tutorial\Http\Controllers\TutorialContentController;
use Modules\Tutorial\Http\Controllers\TutorialController;

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

Route::middleware('auth:api')->get('/tutorial', function (Request $request) {
    return $request->user();
});

Route::prefix('tutorial')->group(function () {
    Route::get('', [TutorialController::class, 'index']);
    Route::prefix('content')->group(function () {
        Route::get('', [TutorialContentController::class, 'index']);
        Route::post('', [TutorialContentController::class, 'store']);
        Route::delete("{id}", [TutorialContentController::class, 'destroy']);
    });
});
