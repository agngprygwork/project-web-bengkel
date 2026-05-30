<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mekanik\DashboardController as MekanikDashboard;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\PembayaranController;
use Illuminate\Support\Facades\Route;

// ── Guest ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('/login',     [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login'])->name('login.post');
    Route::get('/register',  [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ── Midtrans Webhook (NO auth — Midtrans server memanggil ini) ─────────────────
Route::post('/webhook/midtrans', [PembayaranController::class, 'webhook'])
    ->name('webhook.midtrans');

// ── Admin ──────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    });

// ── Mekanik ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:mekanik'])
    ->prefix('mekanik')->name('mekanik.')
    ->group(function () {
        Route::get('/dashboard', [MekanikDashboard::class, 'index'])->name('dashboard');
    });

// ── Customer ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')->name('customer.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');

        // Booking
        Route::get('/booking',          [BookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/create',   [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking',         [BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{kode}',   [BookingController::class, 'show'])->name('booking.show');

        // Riwayat service
        Route::get('/riwayat',          [BookingController::class, 'index'])->name('riwayat.index');

        // Pembayaran
        Route::get('/pembayaran',                          [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{kode}',                   [PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::get('/pembayaran/{kode}/finish',            [PembayaranController::class, 'finish'])->name('pembayaran.finish');
        Route::get('/pembayaran/{kode}/check-status',      [PembayaranController::class, 'checkStatus'])->name('pembayaran.check-status');
    });
