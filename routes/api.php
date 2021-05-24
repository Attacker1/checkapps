<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'guest'], static function() {
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/purchase-items', [CheckController::class, 'getPurchaseListItems'])->name('check-items');
    Route::post('/reject', [CheckController::class, 'reject'])->name('reject');
    Route::post('/approve', [CheckController::class, 'approve'])->name('approve');
});


