<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KitchenCarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/foods_bond', [MainController::class, 'foods_bond'])->name('foods_bond');
Route::get('shop/list', [MainController::class, 'shop_list'])->name('shop.list');
Route::get('/shop/{id}/{name?}', [MainController::class, 'shop'])->name('shop');
Route::get('register', [MainController::class, 'register'])->name('firebase.register');
Route::get('/mypage', [MainController::class, 'mypage'])->name('mypage');
Route::get('/account/edit', [MainController::class, 'account_edit'])->name('account.edit');
Route::get('/followed', [MainController::class, 'followed'])->name('followed');
Route::get('/shop/edit/{id}', [MainController::class, 'shop_edit'])->name('shop.edit');
Route::get('/shop/setup/{id}', [MainController::class, 'shop_setup'])->name('shop.setup');
Route::get('/terms', [MainController::class, 'terms'])->name('terms');
Route::get('/policy', [MainController::class, 'policy'])->name('policy');
//Route::get('/labels', [MainController::class, 'labels'])->name('labels');
Route::get('/contact', [MainController::class, 'contact'])->name('contact');
