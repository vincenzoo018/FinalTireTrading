<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/product', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::post('/product', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/stockadjustments', [AdminController::class, 'stockadjustments'])->name('stockadjustments');
    Route::get('/suppliers', [\App\Http\Controllers\Admin\SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [\App\Http\Controllers\Admin\SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/employee', [AdminController::class, 'employee'])->name('employee');
});

// Add other routes as needed

use App\Http\Controllers\CustomerController;

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/home', [CustomerController::class, 'home'])->name('home');
    Route::get('/products', [CustomerController::class, 'products'])->name('products');
    Route::get('/services', [CustomerController::class, 'services'])->name('services');
    Route::get('/booking', [CustomerController::class, 'booking'])->name('booking');
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/feedback', [CustomerController::class, 'feedback'])->name('feedback');
    Route::get('/logout', [CustomerController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'show'])->name('profile');
});


Route::get('/customer/home', [App\Http\Controllers\Customer\HomeController::class, 'index'])->name('customer.home');



// routes/web.php

use App\Http\Controllers\Admin\CategoriesController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});



use App\Http\Controllers\Admin\ServiceController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
});

use App\Http\Controllers\Admin\EmployeeController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
});

use App\Http\Controllers\AuthController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/customer/products', [\App\Http\Controllers\Customer\ProductController::class, 'index'])->name('customer.products');
Route::get('/customer/services', [App\Http\Controllers\Customer\ServiceController::class, 'index'])->name('customer.services');