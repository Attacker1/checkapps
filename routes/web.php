<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', [SpaController::class, 'index'])->where('any', '.*');

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/purchase-items', [CheckController::class, 'getPurchaseListItems'])->name('check-items');
    Route::post('/reject', [CheckController::class, 'reject'])->name('reject');
    Route::post('/approve', [CheckController::class, 'approve'])->name('approve');
});
