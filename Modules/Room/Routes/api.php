<?php

use Illuminate\Http\Request;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\HomePage\Http\Controllers\HomePageController;
use Modules\Room\Http\Controllers\BenefitController;
use Modules\Room\Http\Controllers\FrontLiveClassController;
use Modules\Room\Http\Controllers\LiveController;
use Modules\Room\Http\Controllers\SchedulerController;
use Modules\Room\Http\Controllers\VideoController;

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

Route::prefix('front-end')->group(function () {
    Route::prefix('live')->group(function () {
        Route::get('', [FrontLiveClassController::class, 'indexALl']);
        Route::get('{id}', [FrontLiveClassController::class, 'show']);
    });
});
Route::middleware('auth:api')->get('/room', function (Request $request) {
    return $request->user();
});
Route::prefix('live')->middleware(["auth:sanctum"])->group(function () {
    Route::prefix('summary')->group(function () {
        Route::get('', [LiveController::class, 'summary']);
    });
    Route::prefix('schedule')->group(function () {
        Route::get('', [SchedulerController::class, 'index']);
        Route::post('', [SchedulerController::class, 'store']);
    });
    Route::prefix('benefit')->group(function () {
        Route::get('{class_id}', [BenefitController::class, 'index']);
        Route::post('{class_id}', [BenefitController::class, 'store']);
    });
    Route::post('add-url/{id}', [LiveController::class, 'addPreviewClass']);
    Route::get('', [LiveController::class, 'index']);
    Route::get('{id}', [LiveController::class, 'showLiveClass']);
    Route::post('', [LiveController::class, 'store']);
    Route::put('{id}', [LiveController::class, 'update']);
    Route::delete('{id}', [LiveController::class, 'destroy']);
    Route::put('{id}/restore', [LiveController::class, 'restore']);
});

Route::prefix('video_class')->middleware(["auth:sanctum"])->group(function () {
    Route::prefix('summary')->group(function () {
        Route::get('', [VideoController::class, 'summary']);
    });
    Route::get('', [VideoController::class, 'index']);
    Route::post('', [VideoController::class, 'store']);
    Route::get('{id}', [VideoController::class, 'show']);
});

Route::prefix("dashboard")->middleware("auth:sanctum")->group(function () {
    Route::prefix("banner")->group(function () {
        Route::get("", [DashboardController::class, 'index']);
        Route::post("", [DashboardController::class, 'storeBanner']);
    });
});
