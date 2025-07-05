<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

// Halaman utama (Welcome Page)
Route::get('/', function () {
    return view('welcome');
});

// Middleware untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup Rute untuk Admin (Hanya Admin yang bisa mengakses)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Grup Rute untuk Kasir (Hanya Kasir yang bisa mengakses)
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/kasir', [TransactionController::class, 'index'])->name('kasir.index');
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/create', [TransactionController::class, 'create'])->name('create');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [TransactionController::class, 'update'])->name('update');
    Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('destroy');
});

// Rute Laporan (Bisa diakses oleh Admin dan Kasir)
Route::middleware('auth')->get('/laporan', [TransactionController::class, 'report'])->name('laporan.index');

require __DIR__.'/auth.php';
