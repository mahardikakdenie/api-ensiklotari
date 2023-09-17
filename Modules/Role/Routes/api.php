<?php

use Illuminate\Http\Request;
use Modules\Role\Entities\Permission;
use Modules\Role\Http\Controllers\PermissionController;
use Modules\Role\Http\Controllers\RoleController;
use Modules\Role\Http\Controllers\RoleSummaryController;

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

Route::middleware('auth:api')->get('/role', function (Request $request) {
    return $request->user();
});
// middleware(['auth:sanctum', 'role:1'])
Route::prefix('roles')->group(function () {
    Route::prefix('summary')->group(function () {
        Route::get('', [RoleSummaryController::class, 'index']);
    });
    Route::prefix('permission')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
        Route::post('/', [PermissionController::class, 'store']);
    });
    Route::get("/", [RoleController::class, 'index']);
    Route::post("/", [RoleController::class, 'store']);
});
