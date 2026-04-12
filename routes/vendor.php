<?php

use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorDiscountCodeController;
use App\Http\Controllers\Vendor\VendorNotificationController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorPayoutController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorProfileController;
use App\Http\Controllers\Vendor\VendorReportController;
use App\Http\Controllers\Vendor\VendorReturnController;
use Illuminate\Support\Facades\Route;

// Auth (guest)
Route::prefix('vendor')->name('vendor.')->middleware('guest:vendor')->group(function () {
    Route::get('/login',    [VendorAuthController::class, 'loginView'])->name('login');
    Route::post('/login',   [VendorAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [VendorAuthController::class, 'registerView'])->name('register');
    Route::post('/register',[VendorAuthController::class, 'register'])->name('register.post');
});

// Authenticated vendor
Route::prefix('vendor')->name('vendor.')->middleware('vendor')->group(function () {
    Route::post('/logout', [VendorAuthController::class, 'logout'])->name('logout');

    Route::get('/',          [VendorDashboardController::class, 'index'])->name('dashboard');

    Route::get('/fetch-choices', [VendorProductController::class, 'fetchChoices'])->name('fetch.choices');
    Route::get('/products/create', [VendorProductController::class, 'create'])->name('products.create');
    Route::post('/products', [VendorProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [VendorProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [VendorProductController::class, 'update'])->name('products.update');
    Route::get('/products', [VendorDashboardController::class, 'products'])->name('products');

    Route::get('/orders', [VendorDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/returns', [VendorReturnController::class, 'index'])->name('returns');

    Route::post('/notifications/read-all', [VendorNotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [VendorNotificationController::class, 'read'])->name('notifications.read');

    // Profile & Branding
    Route::get('/profile', [VendorProfileController::class, 'edit'])->name('profile');
    Route::get('/profile/edit', [VendorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [VendorProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [VendorProfileController::class, 'updatePassword'])->name('profile.password');
    
    Route::get('/customers', [VendorDashboardController::class, 'customers'])->name('customers');

    // Discount Codes
    Route::get('/discount-codes/search-products', [VendorDiscountCodeController::class, 'searchProducts'])->name('discount_code.search-products');
    Route::resource('discount_code', VendorDiscountCodeController::class);

    // Reports
    Route::get('/reports', [VendorReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [VendorReportController::class, 'export'])->name('reports.export');

    // Payouts & Earnings
    Route::get('/payouts', [VendorPayoutController::class, 'index'])->name('payouts.index');
    Route::get('/payouts/{id}', [VendorPayoutController::class, 'show'])->name('payouts.show');
    Route::get('/earnings', [VendorPayoutController::class, 'earnings'])->name('earnings.index');
});
