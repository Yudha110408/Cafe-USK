<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// =============================================
// 1. HALAMAN UMUM (TANPA LOGIN)
// =============================================
Route::get('/', fn() => redirect()->route('login'));

Route::get('/home', fn() => redirect()->route('dashboard'))->name('home');

// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// =============================================
// 2. HALAMAN YANG BUTUH LOGIN
// =============================================
Route::middleware('auth')->group(function () {

    // Dashboard redirect berdasarkan role
    Route::get('/dashboard', function() {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('kasir.dashboard');
    })->name('dashboard');

    // =========================================
    // 3. KHUSUS ADMIN SAJA
    // =========================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
        // Admin can view receipts for any transaction
        Route::get('/transactions/receipt/{transaction}', [\App\Http\Controllers\TransactionController::class, 'receipt'])
            ->name('transactions.receipt');
    });

    // =========================================
    // 4. KHUSUS KASIR SAJA
    // =========================================
    Route::middleware('role:kasir')->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'kasirDashboard'])->name('dashboard');

        // POS
        Route::get('/pos', [TransactionController::class, 'pos'])->name('pos.index');
        Route::get('/pos/cart', [TransactionController::class, 'cart'])->name('pos.cart');
        Route::get('/pos/checkout', [TransactionController::class, 'showCheckout'])->name('pos.checkout.show');
        Route::get('/pos/products/search', [ProductController::class, 'search'])->name('pos.products.search');
        Route::post('/pos/scan', [TransactionController::class, 'scanBarcode'])->name('pos.scan');
        Route::post('/pos/add', [TransactionController::class, 'addToCart'])->name('pos.add');
        Route::post('/pos/remove', [TransactionController::class, 'removeFromCart'])->name('pos.remove');
        Route::post('/pos/clear', [TransactionController::class, 'clearCart'])->name('pos.clear');
        Route::post('/pos/checkout', [TransactionController::class, 'checkout'])->name('pos.checkout');

        // History
        Route::get('/history', [TransactionController::class, 'history'])->name('history');
        Route::get('/receipt/{transaction}', [TransactionController::class, 'receipt'])->name('receipt');
    });
});
