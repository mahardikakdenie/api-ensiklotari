<?php

use Illuminate\Http\Request;
use Modules\Gallery\Http\Controllers\GalleryController;

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

Route::middleware('auth:api')->get('/gallery', function (Request $request) {
    return $request->user();
});

Route::prefix("gallery")->group(function () {
    Route::get('', [GalleryController::class, 'index']);
    Route::post('', [GalleryController::class, 'store']);
    Route::get("{id}", [GalleryController::class, 'show']);
    Route::delete("{id}", [GalleryController::class, 'destroy']);
});
