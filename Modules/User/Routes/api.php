<?php

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\InstructorUserStudioController;
use Modules\User\Http\Controllers\MemberClassController;
use Modules\User\Http\Controllers\TeamController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\UserOwnerStudioController;
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

Route::prefix("user")->middleware(["auth:sanctum"])->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::post('', [UserController::class, 'store'])->middleware('role:1');
    Route::prefix('studio')->group(function () {
        Route::prefix('team')->group(function () {
            Route::get('', [TeamController::class, 'index']);
            Route::post('', [TeamController::class, 'store']);
            Route::get('summary', [TeamController::class, 'summary']);
        });
        Route::prefix('member')->group(function () {
            Route::post('', [MemberClassController::class, 'createMemberByAdmin']);
            Route::get('{class_id}', [MemberClassController::class, 'index']);
        });
    });
    Route::prefix('instructors')->group(function () {
        Route::get('', [InstructorUserStudioController::class, 'index']);
    });
    Route::prefix('me')->group(function () {
        Route::get('', [UserController::class, 'me']);
        Route::get('access-control-list', [UserController::class, 'accessControlList']);
        Route::get('studio', [UserOwnerStudioController::class, 'myStudio']);
    });
    Route::prefix('summary')->group(function () {
        Route::get('', [UserSummaryController::class, 'index']);
    });
    Route::get('{id}', [UserController::class, 'show']);
    Route::put('{id}', [UserController::class, 'update'])->middleware('role:1');
});
