<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\HeroSectionController;
use App\Http\Controllers\Api\HeroFeatureController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\CaseTagController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\ProcessController;
use App\Http\Controllers\Api\CtaSectionController;
use App\Http\Controllers\Api\LeadController;

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

// Frontend Content API
Route::get('/settings', [SettingsController::class, 'index']);
Route::get('/hero-sections', [HeroSectionController::class, 'index']);
Route::get('/hero-features', [HeroFeatureController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
Route::get('/cases', [CaseController::class, 'index']);
Route::get('/cases/{id}', [CaseController::class, 'show']);
Route::get('/case-tags', [CaseTagController::class, 'index']);
use App\Http\Controllers\Api\TeamController as ApiTeamController;

Route::get('/case-tags/{id}', [CaseTagController::class, 'show']);
Route::get('/advantages', [AdvantageController::class, 'index']);
Route::get('/advantages/{id}', [AdvantageController::class, 'show']);
Route::get('/processes', [ProcessController::class, 'index']);
Route::get('/processes/{id}', [ProcessController::class, 'show']);
Route::get('/cta-sections', [CtaSectionController::class, 'index']);
Route::get('/leads', [LeadController::class, 'index']);
Route::post('/leads', [LeadController::class, 'store']);
Route::get('/leads/{id}', [LeadController::class, 'show']);

// Team API
Route::get('/teams', [ApiTeamController::class, 'index']);
Route::get('/teams/{id}', [ApiTeamController::class, 'show']);
Route::post('/teams', [ApiTeamController::class, 'store']);
Route::put('/teams/{id}', [ApiTeamController::class, 'update']);
Route::delete('/teams/{id}', [ApiTeamController::class, 'destroy']);

