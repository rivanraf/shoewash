<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. PUBLIC ROUTE (Halaman Landing Page)
Route::get('/', function () {
    return view('welcome'); // Pastikan daftar harga layanan ditampilkan di sini
});

// Harus di luar middleware 'auth' karena Midtrans bukan user yang login
Route::post('/midtrans/callback', [BookingController::class, 'callback']);

Route::get('/booking/receipt/{order_number}', [BookingController::class, 'showReceipt'])->name('booking.receipt');

// 2. CUSTOMER ROUTE (Hanya bisa diakses setelah Login)
Route::middleware(['auth', 'verified'])->group(function () {
    // Redirect otomatis ke form booking jika customer akses /dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('booking.index');
    })->name('dashboard');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');
    Route::get('/booking/track/{order_number}', [BookingController::class, 'track'])->name('booking.track');
    Route::delete('/booking/{id}/cancel', [BookingController::class, 'destroy'])->name('booking.destroy');
    // Fitur Profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. ADMIN ROUTE (Hanya untuk User dengan Role Admin)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // Dashboard Utama & Operasional
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/booking/{id}/update-status', [AdminController::class, 'updateStatus'])->name('admin.booking.update');
    Route::delete('/booking/{id}', [AdminController::class, 'destroy'])->name('admin.booking.destroy');

    // Laporan Keuangan (Report)
    Route::get('/report', [AdminController::class, 'report'])->name('admin.report');

    // Manajemen User (Admin & Staff)
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store'); // Tambahan: Simpan Admin Baru
    Route::patch('/users/{id}/toggle', [AdminController::class, 'toggleStatus'])->name('admin.users.toggle');
    Route::patch('/admin/booking/{id}/status', [BookingController::class, 'updateStatus'])->name('admin.booking.updateStatus');

    Route::prefix('admin')->name('admin.')->group(function() {
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

    Route::post('/settings/update-quota', [\App\Http\Controllers\Admin\ServiceController::class, 'updateQuota'])
         ->name('settings.updateQuota');
    });
});

require __DIR__.'/auth.php';