<?php

use App\Enum\RolesEnum;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckController;

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
    $adminRoleSlug = RolesEnum::ADMIN['role_data']['slug'];
    $superAdminRoleSlug = RolesEnum::SUPER_ADMIN['role_data']['slug'];

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

    Route::group(['prefix' => 'admin', 'middleware' =>  "role:$adminRoleSlug,$superAdminRoleSlug"], function() {
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', [UserController::class, 'users']);
        });
    });
});
