<?php

use Illuminate\Http\Request;
use Modules\Category\Http\Controllers\CategoryController;

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

Route::middleware('auth:api')->get('/category', function (Request $request) {
    return $request->user();
});

Route::prefix("category")->group(function() {
    Route::get('', [CategoryController::class, 'index']);
    Route::post('', [CategoryController::class, 'store'])->middleware(['auth:sanctum', 'role:1']);
    Route::put("/restore/{id}", [CategoryController::class, 'restore'])->middleware(['auth:sanctum', 'role:1']);
    Route::get("{id}", [CategoryController::class, 'show']);
    Route::put("{id}", [CategoryController::class, 'update'])->middleware(['auth:sanctum', 'role:1']);
    Route::delete("{id}", [CategoryController::class, 'destroy'])->middleware(['auth:sanctum', 'role:1']);
});