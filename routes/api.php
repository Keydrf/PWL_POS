<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\BarangController;


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

Route::post('/register', [RegisterController:: class, '__invoke'])->name('registers');
Route::post('/login', [LoginController:: class, '__invoke'])->name('logins');
Route::post('/logout', [LogoutController:: class, '__invoke'])->name('logouts');

//levels
Route::get('levels', [LevelController:: class, 'index']);
Route::post('levels', [LevelController:: class, 'store' ]);
Route::get('levels/{level}', [LevelController:: class, 'show' ]);
Route::put('levels/{level}', [LevelController::class, 'update' ]);
Route::delete('levels/{level}', [LevelController:: class, 'destroy']);

//users
Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

//kategoris
Route::get('kategoris', [KategoriController::class, 'index']);
Route::post('kategoris', [KategoriController::class, 'store']);
Route::get('kategoris/{id}', [KategoriController::class, 'show']);
Route::put('kategoris/{id}', [KategoriController::class, 'update']);
Route::delete('kategoris/{id}', [KategoriController::class, 'destroy']);

//barangs
Route::get('barangs', [BarangController::class, 'index']);
Route::post('barangs', [BarangController::class, 'store']);
Route::get('barangs/{id}', [BarangController::class, 'show']);
Route::put('barangs/{id}', [BarangController::class, 'update']);
Route::delete('barangs/{id}', [BarangController::class, 'destroy']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
