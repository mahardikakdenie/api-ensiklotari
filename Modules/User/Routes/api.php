<?php

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\UserSummaryController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("user")->middleware(["auth:sanctum"])->group(function() {
    Route::get('', [UserController::class, 'index']);
    Route::post('', [UserController::class, 'store'])->middleware('role:1');
    Route::prefix('summary')->group(function() {
        Route::get('', [UserSummaryController::class, 'index']);
    });
    Route::get('{id}', [UserController::class, 'show']);
    Route::put('{id}', [UserController::class, 'update'])->middleware('role:1');
});

