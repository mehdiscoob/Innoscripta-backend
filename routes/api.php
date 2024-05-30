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

Route::group([], function () {

    Route::prefix('article')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    });

    Route::middleware(['auth:api'])->prefix('article')->group(function () {
        Route::get('/personalized-feed', [ArticleController::class, 'getPersonalizedFeed'])->name('articles.personalized-feed');
//        Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
//        Route::get('/{id}', [ArticleController::class, 'show'])->name('articles.show');
//        Route::put('/{id}', [ArticleController::class, 'update'])->name('articles.update');
//        Route::delete('/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });

    Route::middleware(['auth:api'])->prefix('user-preference')->group(function () {
//        Route::get('/', [UserPreferenceController::class, 'index'])->name('user-preferences.index');
//        Route::post('/', [UserPreferenceController::class, 'store'])->name('user-preferences.create');
        Route::put('/auth', [UserPreferenceController::class, 'updateByAuth'])->name('user-preferences.update.auth');
        Route::get('/auth', [UserPreferenceController::class, 'getByAuth'])->name('user-preferences.getAuth');
//        Route::get('/{id}', [UserPreferenceController::class, 'show'])->name('user-preferences.show');
//        Route::get('/user/{userId}', [UserPreferenceController::class, 'getByUserId'])->name('user-preferences.getUserById');
//        Route::put('/{id}', [UserPreferenceController::class, 'update'])->name('user-preferences.update');
//        Route::put('/user/{userId}', [UserPreferenceController::class, 'updateByUserId'])->name('user-preferences.update');
//        Route::delete('/{id}', [UserPreferenceController::class, 'destroy'])->name('user-preferences.destroy');
//        Route::delete('/user/{userId}', [UserPreferenceController::class, 'deleteByUserId'])->name('user-preferences.deleteByUserId');
    });
});
