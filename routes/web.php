<?php

use App\Http\Controllers\Inertia\UserAuthController;
use App\Http\Controllers\Inertia\CategoryController;
use App\Http\Controllers\Inertia\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware(['web'])->group(function () {
//     Route::get('/auth/login', [UserAuthController::class, 'loginView'])->name('login.view');
//     Route::post('/auth/login', [UserAuthController::class, 'login'])->name('login');
//     Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
// });
Route::middleware(['web'])->prefix('auth')->group(function () {
    Route::get('/login', [UserAuthController::class, 'loginView'])->name('login');
    Route::get('/register', [UserAuthController::class, 'registerView'])->name('register');
    Route::get('/forgot-password', [UserAuthController::class, 'forgotPasswordView'])->name('forgot');
    Route::get('/reset-password', [UserAuthController::class, 'resetPasswordView'])->name('reset');

    Route::post('/login', [UserAuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [UserAuthController::class, 'register'])->name('auth.register');
    Route::post('/verify', [UserAuthController::class, 'verifyCode'])->name('auth.verify');
    Route::post('/forgot-password', [UserAuthController::class, 'forgotPassword'])->name('auth.forgot');
    Route::post('/update-password', [UserAuthController::class, 'passwordUpdate'])->name('auth.update');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('auth.logout');
});

// Route::middleware('guest:web')->prefix('auth')->group(function () {
//     Route::get('/login', [UserAuthController::class, 'loginView'])->name('login.view');
//     Route::post('/login', [UserAuthController::class, 'login'])->name('login');

//     Route::get('/register', [UserAuthController::class, 'registerView'])->name('register.view');
//     Route::post('/register', [UserAuthController::class, 'register'])->name('register');

//     Route::get('/verify', [UserAuthController::class, 'verifyCodeView'])->name('verify.view');
//     Route::post('/verify', [UserAuthController::class, 'verifyCode'])->name('verify');

//     Route::get('/forgot-password', [UserAuthController::class, 'forgotPasswordView'])->name('forgot.view');
//     Route::get('/reset-password', [UserAuthController::class, 'resetPasswordView'])->name('reset.view');
// });

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    // صفحة الحساب الشخصي
    Route::get('/account', function () {
        return Inertia::render('Account/Index');
    })->name('account');
});

Route::get('/', [\App\Http\Controllers\Inertia\HomeController::class, 'index'])->name('home');


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('productss.show');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('categories.show');
});





// /* user Auth */
// Route::get('/user/register', [\App\Http\Controllers\Front\UserAuthController::class, 'registerView'])->name('register');
// Route::post('/register', [\App\Http\Controllers\Front\UserAuthController::class, 'register'])->name('user.register');
// Route::post('/register-verifyCode', [\App\Http\Controllers\Front\UserAuthController::class, 'verifyCode'])->name('verifyCode');
// Route::get('/user/login', [\App\Http\Controllers\Front\UserAuthController::class, 'loginView'])->name('userLogin');
// Route::post('login', [\App\Http\Controllers\Front\UserAuthController::class, 'login'])->name('login');
// Route::get('user/forgot-password', [\App\Http\Controllers\Front\UserAuthController::class, 'forgotPasswordView'])->name('user.forgotPassword');
// Route::post('forgotPassword', [\App\Http\Controllers\Front\UserAuthController::class, 'forgotPassword'])->name('forgotPassword');
// Route::post('verifyToResetPassword', [\App\Http\Controllers\Front\UserAuthController::class, 'verifyToResetPassword'])->name('verifyToResetPassword');
// Route::get('user/reset-password', [\App\Http\Controllers\Front\UserAuthController::class, 'resetPasswordView'])->name('user.resetPassword');
// Route::post('/password-update', [\App\Http\Controllers\Front\UserAuthController::class, 'passwordUpdate'])->name('password.update');
// Route::post('/resend-verify-code', [\App\Http\Controllers\Front\UserAuthController::class, 'resendVerifyCode'])->name('resendVerifyCode');

// // user Auth routes
// Route::middleware('auth:web')->group(function () {
//     Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user.profile');
//     Route::post('/wishlist2/{id}', [WishListController::class, 'wishListInProductDetails'])->name('wishlist_product_details');
//     /* المفضلة */
//     Route::get('/user_wishlist', [UserProfileController::class, 'userWishList'])->name('user.wishlist');
//     Route::get('/user_info', [UserProfileController::class, 'userInfo'])->name('user.info');
//     Route::get('/user_addresses', [UserProfileController::class, 'userAddresses'])->name('user.addresses');
//     Route::get('/user_addresses/create', [UserProfileController::class, 'userAddressesCreate'])->name('create.address');
//     Route::post('/user_addresses/store', [UserProfileController::class, 'userAddressesStore'])->name('store.address');
//     Route::get('/user_addresses/{addressId}/edit', [UserProfileController::class, 'userAddressesEdit'])->name('edit.address');
//     Route::put('/user_addresses/{addressId}/update', [UserProfileController::class, 'userAddressesUpdate'])->name('update.address');
//     Route::delete('/user_addresses/{addressId}/delete', [UserProfileController::class, 'userAddressesDestroy'])->name('delete.address');
//     /*new*/
//     Route::post('/user_addresses/{address}/set_main', [UserProfileController::class, 'setMainAddress'])->name('user.addresses.set_main');


//     Route::get('/user_change_password', [UserProfileController::class, 'changePasswordView'])->name('user_password');
//     Route::put('/user_update_info/update', [UserProfileController::class, 'updatePassword'])->name('update_password');
//     Route::put('/user_normal_info/update', [UserProfileController::class, 'updateUserInfo'])->name('update_user_info');
//     Route::post('/user_normal_info/verify_to_update', [UserProfileController::class, 'verify_to_update'])->name('verify_to_update');
//     Route::post('/user_normal_info/resendVerifyCode_to_update', [UserProfileController::class, 'resendVerifyCodeToupdate'])->name('resendVerifyCode_to_update');


//     /* مشاهدة الطلب */
//     Route::get('/user_orders/{number}', [UserOrdersController::class, 'showOrder'])->name('user.orders');
//     /* الطلبات */
//     Route::get('/user_main_orders', [UserOrdersController::class, 'mainOrders'])->name('user.main.orders');
//     /* حذف طلب */
//     Route::delete('/user_orders/delete', [UserOrdersController::class, 'destroy'])->name('order.delete');


//     /* المرتجعات */
//     Route::get('/user_return_orders', [ReturnProductsController::class, 'index'])->name('user.return_products');
//     Route::post('/user_return_orders/store', [ReturnProductsController::class, 'store'])->name('user.return_products.store');


//     #################################################--Comments Routes
//     Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');
// });
// Route::get('/user/payment/{order_number}', [\App\Http\Controllers\Front\PaymentController::class, 'index'])->name('user.payment');
// /*عملية الدفع*/
// Route::get('/user_orders/{number}/payment/callback', [\App\Http\Controllers\Front\PaymentController::class, 'callback'])->name('payment.callback');
// //Route::get('/user_orders/{number}/payment/callback', [\App\Http\Controllers\Front\PaymentController::class, 'callback'])->name('payment.callback');

require __DIR__ . '/dashboard.php';
