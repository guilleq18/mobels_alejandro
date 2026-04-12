<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\QuoteRequestController as AdminQuoteRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\UploadedAssetController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/uploads/{path}', [UploadedAssetController::class, 'show'])
    ->where('path', '.*')
    ->name('uploads.show');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/productos/{product}/presupuesto', [QuoteRequestController::class, 'store'])->name('products.quote-requests.store');

Route::prefix('admin')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
    });

    Route::middleware('auth')->name('admin.')->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::resource('categorias', AdminCategoryController::class)
            ->except('show')
            ->names('categories')
            ->parameters(['categorias' => 'category']);
        Route::resource('productos', AdminProductController::class)
            ->except('show')
            ->names('products')
            ->parameters(['productos' => 'product']);
        Route::get('/presupuestos', [AdminQuoteRequestController::class, 'index'])->name('quote-requests.index');
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    });
});
