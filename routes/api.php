<?php

use App\Http\Controllers\UserPreference\UserPreferenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Article\ArticleController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::middleware(['auth:api'])->prefix('article')->group(function () {
        Route::get('/', [ArticleController::class, "index"])->name('article');
        Route::get('/{id}', [ArticleController::class, "show"])->name('article.id');
    });

    Route::middleware(['auth:api'])->prefix('user-preference')->group(function () {
        Route::get('/user/preferences', [UserPreferenceController::class, 'getUserPreferences']);
        Route::post('/user/preferences', [UserPreferenceController::class, 'updateUserPreferences']);
    });
});
