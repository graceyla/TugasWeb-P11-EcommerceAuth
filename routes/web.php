<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EagerLoadingController;
use App\Http\Controllers\Kelola\PostController as KelolaPostController;
use App\Http\Controllers\Kelola\UserController as KelolaUserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// ===== publik (tanpa login) =====
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produk/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/artikel', [PostController::class, 'index'])->name('posts.index');
Route::get('/artikel/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/eager-loading', EagerLoadingController::class)->name('eager-loading');

// ===== harus login (semua role) =====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== admin & editor =====
Route::middleware(['auth', 'role:admin,editor'])->prefix('kelola')->name('kelola.')->group(function () {
    Route::resource('posts', KelolaPostController::class)->except('show');
});

// ===== khusus admin =====
Route::middleware(['auth', 'role:admin'])->prefix('kelola')->name('kelola.')->group(function () {
    Route::get('users', [KelolaUserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/role', [KelolaUserController::class, 'updateRole'])->name('users.role');
});

require __DIR__.'/auth.php';
