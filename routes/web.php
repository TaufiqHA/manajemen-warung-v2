<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rute Halaman Login (TIDAK BOLEH dikunci oleh check.login)
Route::get('/', function () {
    return view('login');
});

// Rute autentikasi
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rute terproteksi: Terapkan middleware kustom `check.login`
Route::get('/me', [AuthController::class, 'me'])->middleware('check.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('check.login')->name('logout');

// Contoh penerapan perlindungan untuk masuk ke dashboard
Route::view('/dashboard', 'dashboard')->middleware('check.login');
