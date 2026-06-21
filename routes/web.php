<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('check.login');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('check.login');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('check.login');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('check.login');

// Route Transactions
Route::resource('transactions', App\Http\Controllers\TransactionController::class)->middleware('check.login');

// Rute Profil User
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index')->middleware('check.login');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('check.login');
Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('check.login');
