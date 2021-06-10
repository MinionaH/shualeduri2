<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [AuthController::class, 'login'])->name('api.users.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.users.register');
Route::post('/fill-balance', [BalanceController::class, 'fill_balance'])->name('api.users.fill_balance');
Route::get('/balance/history', [BalanceController::class, 'fill_history'])->name('api.users.fill_history');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/transfer/{user}', [TransactionController::class, 'transfer'])->name('api.users.transfer');
    Route::get('/my-transactions', [TransactionController::class, 'my_transactions'])->name('api.users.my_transactions');
    Route::get('/transactions', [TransactionController::class, 'transactions_history'])->name('api.users.transactions_history');
});
