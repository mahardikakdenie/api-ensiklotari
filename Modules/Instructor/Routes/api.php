<?php

use Illuminate\Http\Request;
use Modules\Instructor\Http\Controllers\InstructorController;

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

Route::middleware('auth:api')->get('/instructor', function (Request $request) {
    return $request->user();
});

Route::prefix("instructor")->middleware(['auth:sanctum'])->group(function () {
    Route::get('', [InstructorController::class, 'index']);
    Route::post('', [InstructorController::class, 'store']);
    Route::get("{id}", [InstructorController::class, 'show']);
    Route::put('{id}', [InstructorController::class, 'update']);
    Route::delete('{id}', [InstructorController::class, 'destroy']);
    Route::get('{slug}/slug', [InstructorController::class, 'showBySlug']);
});
