<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'registerApi']);

Route::post('login', [AuthController::class, 'loginApi']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logoutApi']);

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::apiResource('categories',CategoryController::class);
        Route::apiResource('products',ProductController::class);
        Route::apiResource('transactions',TransactionController::class);
    });

    Route::middleware('role:nonadmin')->prefix('finbiz')->group(function () {
        Route::apiResource('transactions',TransactionController::class)->only(['index','store','show']);
        Route::apiResource('products',ProductController::class)->only(['index','show']);
    });
});


















/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Berikut adalah daftar URL yang terbentuk dari apiResource:
|
| METHOD | URL                     | FUNGSI        | CONTROLLER METHOD
|--------|-------------------------|---------------|------------------
| GET    | /api/products           | List Semua    | index
| POST   | /api/products           | Tambah Baru   | store
| GET    | /api/products/{id}      | Detail 1 item | show
| PUT    | /api/products/{id}      | Edit item     | update
| DELETE | /api/products/{id}      | Hapus item    | destroy
|
*/


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Berikut adalah daftar URL yang terbentuk dari apiResource:
|
| METHOD | URL                     | FUNGSI        | CONTROLLER METHOD
|--------|-------------------------|---------------|------------------
| GET    | /api/transactions       | List Semua    | index
| POST   | /api/transactions       | Tambah Baru   | store
| GET    | /api/transactions/{id}      | Detail 1 item | show
| PUT    | /api/transactions/{id}      | Edit item     | update
| DELETE | /api/transactions/{id}      | Hapus item    | destroy
|
*/

