<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

// Halaman Depan Publik
Route::get('/', [RedirectController::class, 'home'])->name('home');

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Panel Pengguna Terautentikasi
Route::middleware('auth')->group(function () {
    Route::redirect('/dashboard', '/urls')->name('dashboard');

    // Manajemen Tautan Pendek
    Route::get('/urls', [ShortUrlController::class, 'index'])->name('urls.index');
    Route::post('/urls', [ShortUrlController::class, 'store'])->name('urls.store');
    Route::put('/urls/{url}', [ShortUrlController::class, 'update'])->name('urls.update');
    Route::delete('/urls/{url}', [ShortUrlController::class, 'destroy'])->name('urls.destroy');
    Route::get('/urls/{url}/qr', [ShortUrlController::class, 'qrCode'])->name('urls.qr');
});

// Pengalihan Tautan Pendek (Wildcard di posisi terakhir)
Route::get('/{code}', [RedirectController::class, 'redirect'])
    ->where('code', '[a-zA-Z0-9_\-]+')
    ->name('short.redirect');
