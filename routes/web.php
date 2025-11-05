<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes yang butuh autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::resource('/admin/products', AdminProductController::class)->names('admin.products');
    });

    // Kasir Routes
    Route::middleware('role:kasir')->group(function () {
        Route::get('/kasir', [DashboardController::class, 'kasir'])->name('kasir.dashboard');
    });

    // Report Routes (Admin & Kasir)
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('report.print');
    });

    // Pelanggan Routes
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/pelanggan', [DashboardController::class, 'pelanggan'])->name('pelanggan.dashboard');
    });

    // Cart Routes (all authenticated users)
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Transaction Routes
    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('/transaction/receipt/{id}', [TransactionController::class, 'receipt'])->name('transaction.receipt');
    Route::get('/transaction/success/{id}', [TransactionController::class, 'success'])->name('transaction.success');
    Route::get('/transaction/history', [TransactionController::class, 'history'])->name('transaction.history');
});