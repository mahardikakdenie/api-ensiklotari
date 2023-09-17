<?php

use Illuminate\Http\Request;
use Modules\Certificate\Http\Controllers\CertificateController;

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

Route::middleware('auth:api')->get('/certificate', function (Request $request) {
    return $request->user();
});

Route::prefix('certificates')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::prefix('manage')
            ->group(function () {
                Route::post('add', [CertificateController::class, 'store']);
                Route::delete('{id}', [CertificateController::class, 'destroy']);
                Route::put('{id}/update', [CertificateController::class, 'update']);
            });
        Route::get('my-certificates', [CertificateController::class, 'myCertificates']);
        Route::get('', [CertificateController::class, 'index']);
        Route::get('{id}', [CertificateController::class, 'show']);
        Route::get('{slug}/slug', [CertificateController::class, 'showBySlug']);
    });
