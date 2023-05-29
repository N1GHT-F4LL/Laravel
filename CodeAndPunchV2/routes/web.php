<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route cho các menu chính
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route cho quản lý thông tin người dùng
Route::prefix('users')->group(function () {
   Route::middleware('auth')->group(function () {
      Route::get('/', [UserController::class, 'index'])->name('users.index');
      Route::get('/profile/{user}', [UserController::class, 'profile'])->name('users.profile');
      Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
      Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
      Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   });
});