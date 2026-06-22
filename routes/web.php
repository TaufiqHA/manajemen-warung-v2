<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
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
Route::resource('transactions', TransactionController::class)->middleware('check.login');

// Rute Profil User
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('check.login');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('check.login');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('check.login');

// Route untuk Owner
Route::get('/owner/dashboard', [OwnerController::class, 'index'])
    ->name('owner.dashboard')
    ->middleware('check.login');
