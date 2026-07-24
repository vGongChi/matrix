<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontAuthController;
use App\Http\Controllers\FrontOrderController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/{id}', [TeamController::class, 'show'])->name('team.show');
Route::get('material', [MaterialController::class, 'index'])->name('material.index');
Route::get('/material/{id}', [MaterialController::class, 'show'])->name('material.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

//登录相关
Route::post('/auth/send-code', [FrontAuthController::class, 'sendCode'])->name('auth.send-code');
Route::post('/auth/register', [FrontAuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [FrontAuthController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [FrontAuthController::class, 'logout'])->name('auth.logout');

//订单相关
Route::middleware('auth')->group(function () {
    Route::get('/orders', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [FrontOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [FrontOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [FrontOrderController::class, 'show'])->name('orders.show');
});