<?php

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

Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::get("profile/{id}",[\App\Http\Controllers\UserController::class,"findById"]);
});

Route::prefix('user')->group(function () {
Route::get("{id}",[\App\Http\Controllers\UserController::class,"findById"]);
Route::get("/",[\App\Http\Controllers\UserController::class,"getUserPaginate"])->middleware('auth:api');
});

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class,"login"])->name('login');

Route::post('/register', [\App\Http\Controllers\UserController::class,"register"])->name('register');

Route::middleware(['auth:api'])->prefix('article')->group(function () {
    Route::get('/', [\App\Http\Controllers\Article\ArticleController::class,"getArticlePaginate"])->name('article');
    Route::get('/by-user', [\App\Http\Controllers\Article\ArticleController::class,"getArticelsByUserID"])->name('article.by.user');
    Route::get('/{id}', [\App\Http\Controllers\Article\ArticleController::class,"findById"])->name('article.id');
    Route::post('/', [\App\Http\Controllers\Article\ArticleController::class,"store"])->name('article.create');
    Route::patch('/{id}', [\App\Http\Controllers\Article\ArticleController::class,"update"])->name('article.update.id');
    Route::delete('/{id}', [\App\Http\Controllers\Article\ArticleController::class,"delete"])->name('article.delete.id');
    Route::patch('/status/{id}', [\App\Http\Controllers\Article\ArticleController::class,"update"])->name('article.change.status.id');

});
