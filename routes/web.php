<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MaterialController;
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
