<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\Admin\ReportsController as AdminReportsController;
use App\Http\Controllers\Admin\TransactionsController as AdminTransactionsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\NonAdmin\DashboardController as NonAdminDashboardController;
use App\Http\Controllers\NonAdmin\ProductsController as NonAdminProductsController;
use App\Http\Controllers\NonAdmin\ReportsController as NonAdminReportsController;
use App\Http\Controllers\NonAdmin\TransactionsController as NonAdminTransactionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTE AUTENTIKASI (AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/', [LoginController::class, 'showLoginForm'])->name('auth.login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| GRUP RUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Transaksi
    Route::get('/transactions', [AdminTransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [AdminTransactionsController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [AdminTransactionsController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [AdminTransactionsController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [AdminTransactionsController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [AdminTransactionsController::class, 'destroy'])->name('transactions.destroy');

    // Laporan Keuangan
    Route::get('/reports/profit-loss', [AdminReportsController::class, 'profitLoss'])->name('reports.profit-loss');
    Route::get('/reports/cash-flow', [AdminReportsController::class, 'cashFlow'])->name('reports.cash-flow');

    // CRUD Pengguna
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // CRUD Produk
    Route::get('/products', [AdminProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductsController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductsController::class, 'destroy'])->name('products.destroy');

    // CRUD Kategori
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});

/*
|--------------------------------------------------------------------------
| GRUP RUTE NON-ADMIN (STAF / KASIR)
|--------------------------------------------------------------------------
*/
Route::prefix('nonadmin')->name('nonadmin.')->middleware(['auth', 'role:nonadmin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [NonAdminDashboardController::class, 'index'])->name('dashboard');

    // Transaksi (catat & riwayat milik sendiri)
    Route::get('/transactions/create', [NonAdminTransactionsController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [NonAdminTransactionsController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/history', [NonAdminTransactionsController::class, 'history'])->name('transactions.history');

    // Katalog Produk (lihat saja)
    Route::get('/products', [NonAdminProductsController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [NonAdminProductsController::class, 'show'])->name('products.show');

    // Laporan Harian
    Route::get('/reports/daily', [NonAdminReportsController::class, 'daily'])->name('reports.daily');
});