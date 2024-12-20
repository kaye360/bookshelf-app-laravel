<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\ExternalBookSearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::get('/', [PageController::class, 'index']);

Route::view('/dashboard', 'dashboard')->middleware('auth:sanctum');

Route::get('/community', [CommunityPostController::class, 'index']);

Route::get('/user', [ProfileController::class, 'index'])->middleware('auth:sanctum');
Route::get('/user/{username}', [ProfileController::class, 'index'])->middleware('auth:sanctum');

Route::view('/register', 'register');
Route::post('/register', [UserController::class, 'store']);

Route::view('/login', 'login')->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/books', [BookController::class, 'index'])->middleware('auth:sanctum');
Route::get('/books/{key}', [BookController::class, 'show'])->middleware('auth:sanctum');

Route::get('/search', [SearchController::class, 'search'])->middleware('auth:sanctum');
Route::get('/search-result', [SearchController::class, 'result'])->middleware('auth:sanctum');
