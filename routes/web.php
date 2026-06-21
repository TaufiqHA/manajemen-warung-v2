<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;

// Rute Halaman Login (TIDAK BOLEH dikunci oleh check.login)
Route::get('/', function () {
    return view('login');
})->middleware('guest');

// Rute autentikasi
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rute terproteksi: Terapkan middleware kustom `check.login`
Route::get('/me', [AuthController::class, 'me'])->middleware('check.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('check.login')->name('logout');

// Ganti Route::view('/dashboard', ...) dengan memanggil class DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('check.login');
Route::resource('categories', CategoryController::class)->middleware('check.login');
