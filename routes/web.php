<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Welcome/Home Route
Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('welcome');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/product', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::post('/product', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/stockadjustments', [\App\Http\Controllers\Admin\StockAdjustmentController::class, 'index'])->name('stockadjustments.index');
    Route::get('/suppliers', [\App\Http\Controllers\Admin\SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [\App\Http\Controllers\Admin\SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/transactions', [\App\Http\Controllers\Admin\SupplierTransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [\App\Http\Controllers\Admin\SupplierTransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/supplier/{supplierId}/history', [\App\Http\Controllers\Admin\SupplierTransactionController::class, 'supplierHistory'])->name('transactions.supplier.history');
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingsController::class, 'index'])->name('bookings');
    Route::post('/bookings/{booking}/approve', [\App\Http\Controllers\Admin\BookingsController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [\App\Http\Controllers\Admin\BookingsController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/complete', [\App\Http\Controllers\Admin\BookingsController::class, 'complete'])->name('bookings.complete');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/sales', [\App\Http\Controllers\Admin\SalesController::class, 'index'])->name('sales');
    Route::post('/sales/generate', [\App\Http\Controllers\Admin\SalesController::class, 'generateSales'])->name('sales.generate');
    Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/{user}/toggle', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleActive'])->name('customers.toggle');
    Route::post('/customers/{user}/reset-password', [\App\Http\Controllers\Admin\CustomerController::class, 'resetPassword'])->name('customers.reset');
    Route::get('/employee', [AdminController::class, 'employee'])->name('employee');
});

// Add other routes as needed

use App\Http\Controllers\CustomerController;

// Customer Routes
Route::prefix('customer')->name('customer.')->middleware('auth')->group(function () {
    Route::get('/home', [CustomerController::class, 'home'])->name('home');
    Route::get('/products', [CustomerController::class, 'products'])->name('products');
    Route::get('/services', [CustomerController::class, 'services'])->name('services');
    Route::get('/booking', [\App\Http\Controllers\Customer\BookingController::class, 'index'])->name('booking');
    Route::post('/booking', [\App\Http\Controllers\Customer\BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/{booking}/cancel', [\App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/booking/{booking}/completed', [\App\Http\Controllers\Customer\BookingController::class, 'markCompleted'])->name('booking.completed');
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/feedback', [CustomerController::class, 'feedback'])->name('feedback');
    Route::get('/logout', [CustomerController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'show'])->name('profile');
});


Route::get('/customer/home', [App\Http\Controllers\Customer\HomeController::class, 'index'])->name('customer.home')->middleware('auth');



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

// Define login route without prefix for auth middleware
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Customer Routes with Auth Middleware
Route::middleware('auth')->group(function () {
    Route::get('/customer/products', [\App\Http\Controllers\Customer\ProductController::class, 'index'])->name('customer.products');
    Route::get('/customer/services', [App\Http\Controllers\Customer\ServiceController::class, 'index'])->name('customer.services');
    Route::get('/customer/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('customer.cart');
    Route::post('/customer/cart/add', [App\Http\Controllers\Customer\CartController::class, 'add'])->name('customer.cart.add');
    Route::put('/customer/cart/update/{cart}', [App\Http\Controllers\Customer\CartController::class, 'updateQuantity'])->name('customer.cart.update');
    Route::delete('/customer/cart/remove/{cart}', [App\Http\Controllers\Customer\CartController::class, 'remove'])->name('customer.cart.remove');
    Route::delete('/customer/cart/clear', [App\Http\Controllers\Customer\CartController::class, 'clear'])->name('customer.cart.clear');
    Route::get('/customer/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('customer.checkout');
    Route::post('/customer/checkout/complete', [App\Http\Controllers\Customer\CheckoutController::class, 'completePurchase'])->name('customer.checkout.complete');
    Route::get('/customer/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('customer.orders');
    Route::post('/customer/orders/{order}/cancel', [App\Http\Controllers\Customer\OrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/customer/orders/{order}/receive', [App\Http\Controllers\Customer\OrderController::class, 'receive'])->name('customer.orders.receive');
    Route::get('/customer/order/{order}/items', [App\Http\Controllers\Customer\OrderItemController::class, 'index'])->name('customer.order.items');
    
    // Payment routes
    Route::post('/customer/payment/order/{order}', [App\Http\Controllers\Customer\PaymentController::class, 'processOrderPayment'])->name('customer.payment.order');
    Route::post('/customer/payment/booking/{booking}', [App\Http\Controllers\Customer\PaymentController::class, 'processBookingPayment'])->name('customer.payment.booking');
    Route::get('/customer/payment/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'show'])->name('customer.payment.show');
});
Route::get('/admin/orders', [App\Http\Controllers\Admin\OrdersController::class, 'index'])->name('admin.orders');
Route::post('/admin/orders/{order}/approve', [App\Http\Controllers\Admin\OrdersController::class, 'approve'])->name('admin.orders.approve');
Route::post('/admin/orders/{order}/reject', [App\Http\Controllers\Admin\OrdersController::class, 'reject'])->name('admin.orders.reject');
Route::post('/admin/stockadjustments', [App\Http\Controllers\Admin\StockAdjustmentController::class, 'store'])->name('admin.stockadjustments.store');
Route::get('/admin/stockadjustments', [App\Http\Controllers\Admin\StockAdjustmentController::class, 'index'])->name('admin.stockadjustments.index');

// Admin Stock Adjustment Approval Routes - Only for role_id 1 (Admin)
Route::prefix('admin/stockadjustments/approvals')->name('admin.stockadjustments.approvals.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminStockAdjustmentController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\Admin\AdminStockAdjustmentController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [App\Http\Controllers\Admin\AdminStockAdjustmentController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [App\Http\Controllers\Admin\AdminStockAdjustmentController::class, 'reject'])->name('reject');
    Route::post('/bulk-approve', [App\Http\Controllers\Admin\AdminStockAdjustmentController::class, 'bulkApprove'])->name('bulk-approve');
});

// Simple notifications routes for employee
