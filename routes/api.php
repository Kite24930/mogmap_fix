<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/accountVerification', [ApiController::class, 'accountVerification'])->name('accountVerification');
Route::post('/followedGet', [ApiController::class, 'followedGet'])->name('followedGet');
Route::post('/shop/follow/check', [ApiController::class, 'followCheck'])->name('shop.follow.check');
Route::post('/shop/follow', [ApiController::class, 'follow'])->name('shop.follow');
Route::post('/account/name', [ApiController::class, 'accountName'])->name('account.name');
Route::post('/setup/register', [ApiController::class, 'setup_register'])->name('setup.register');
Route::post('/setup/canceled', [ApiController::class, 'setup_canceled'])->name('setup.canceled');
Route::post('/setup/cancellation', [ApiController::class, 'setup_cancellation'])->name('setup.cancellation');
Route::post('/setup/delete', [ApiController::class, 'setup_deleted'])->name('setup.delete');
Route::post('/user/register', [ApiController::class, 'user_register'])->name('user.register');
