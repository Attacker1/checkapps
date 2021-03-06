<?php

use App\Enum\PermissionsEnum;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;

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

Route::group(['middleware' => 'guest'], static function () {
    Route::post('/login', LoginController::class)->name('login');
});

Route::group(['middleware' => 'auth:api'], static function () {
    $canViewAdminPages = PermissionsEnum::CAN_VIEW_ADMIN_PAGES['slug'];
    $canEditSettings = PermissionsEnum::CAN_EDIT_SETTINGS['slug'];
    $canManagePermissions = PermissionsEnum::CAN_MANAGE_PERMISSION['slug'];

    /**
     * GET
     */
    Route::get('user', [UserController::class, 'user']);
    Route::middleware('recaptcha')->get('purchase-items', [CheckController::class, 'getChecks']);
    Route::get('check-histories', [UserController::class, 'checkHistories']);

    /**
     * POST
     */
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::post('reject', [CheckController::class, 'reject']);
    Route::post('approve', [CheckController::class, 'approve']);
    Route::post('skip', [CheckController::class, 'skipCheck']);
    Route::post('reset-checks', [CheckController::class, 'resetChecks']);

    /**
     * GROUP
     */
    Route::group(['middleware' => "permission:$canViewAdminPages"], function () {
        Route::group(['prefix' => 'users'], function () {
            /**
             * GET
             */
            Route::get('/', [UserController::class, 'users']);
            Route::get('/{user_id}', [UserController::class, 'getUser']);
            Route::get('/{user_id}/block', [UserController::class, 'blockUser']);
            Route::get('/{user_id}/unblock', [UserController::class, 'unblockUser']);

            /**
             * POST
             */
            Route::post('manage-permissions', [UserController::class, 'managePermissions']);
        });
    });

    Route::group(['middleware' => "permission:$canEditSettings"], function () {
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingController::class, 'settings']);
            Route::post('/edit', [SettingController::class, 'edit']);
        });
    });

    Route::group(['middleware' => "permission:$canManagePermissions"], function () {
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'permissions']);
        });
    });
});
