<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/product', [AdminController::class, 'product'])->name('product');
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
    Route::get('/supplier', [AdminController::class, 'supplier'])->name('supplier');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/employee', [AdminController::class, 'employee'])->name('employee');
});

// Add other routes as needed