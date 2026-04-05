<?php

use App\Http\Controllers\Inertia\UserAuthController;
use App\Http\Controllers\Inertia\CategoryController;
use App\Http\Controllers\Inertia\ProductController;
use App\Http\Controllers\Inertia\UserProfileController;
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


Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    // صفحة الحساب الشخصي
    Route::get('/account', function () {
        return Inertia::render('Account/Index');
    })->name('account');
});

// Newsletter subscription
Route::post('/subscribe', [\App\Http\Controllers\Inertia\NewsletterController::class, 'store'])->name('newsletter.subscribe');
// Search (live JSON for navbar + full page redirect)
Route::get('/search', [\App\Http\Controllers\Inertia\SearchController::class, 'search'])->name('search');
// Reviews (public read)
Route::get('/reviews/{productId}', [\App\Http\Controllers\Inertia\ReviewController::class, 'index'])->name('reviews.index');
// Compare
Route::get('/compare', [\App\Http\Controllers\Inertia\CompareController::class, 'index'])->name('compare');

Route::get('/', [\App\Http\Controllers\Inertia\HomeController::class, 'index'])->name('home');

// Offers
Route::get('/offers', [\App\Http\Controllers\Inertia\OfferProductController::class, 'index'])->name('offers');

// Brands
Route::get('/brands', [\App\Http\Controllers\Inertia\BrandsController::class, 'index'])->name('brands.index');
Route::get('/brands/{id}', [\App\Http\Controllers\Inertia\BrandsController::class, 'show'])->name('brands.show');

// Contact Us
Route::get('/contact-us', [\App\Http\Controllers\Inertia\ContactUsController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [\App\Http\Controllers\Inertia\ContactUsController::class, 'store'])->name('contact.store');

// Bulk Order (طلبات الجملة)
Route::get('/bulk-order', [\App\Http\Controllers\Inertia\BulkOrderController::class, 'index'])->name('bulk.index');
Route::post('/bulk-order', [\App\Http\Controllers\Inertia\BulkOrderController::class, 'store'])->name('bulk.store');

// Representative Order (طلبات المناديب)
Route::get('/representative-order', [\App\Http\Controllers\Inertia\RepresentativeOrderController::class, 'index'])->name('representative.index');
Route::post('/representative-order', [\App\Http\Controllers\Inertia\RepresentativeOrderController::class, 'store'])->name('representative.store');

// Static Pages
Route::get('/shipping-policy',    [\App\Http\Controllers\Inertia\StaticPageController::class, 'shipping_policy'])->name('shipping.policy');
Route::get('/terms-conditions',   [\App\Http\Controllers\Inertia\StaticPageController::class, 'terms_conditions'])->name('terms.conditions');
Route::get('/privacy-policy',     [\App\Http\Controllers\Inertia\StaticPageController::class, 'privacy_policy'])->name('privacy.policy');
Route::get('/exchanges-returns',  [\App\Http\Controllers\Inertia\StaticPageController::class, 'exchanges_returns'])->name('exchanges.returns');
Route::get('/faq',                [\App\Http\Controllers\Inertia\StaticPageController::class, 'questions'])->name('faq');

// Cart routes (web - cookie based, works for guests and users)
Route::post('/cart/add', [\App\Http\Controllers\Inertia\CartController::class, 'store'])->name('cart.add');
Route::get('/cart', [\App\Http\Controllers\Inertia\CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/{id}', [\App\Http\Controllers\Inertia\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [\App\Http\Controllers\Inertia\CartController::class, 'destroy'])->name('cart.destroy');

// Checkout
Route::get('/checkout', [\App\Http\Controllers\Inertia\CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout', [\App\Http\Controllers\Inertia\CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/checkout/apply-discount', [\App\Http\Controllers\Inertia\CheckoutController::class, 'applyDiscount'])->name('checkout.discount');

// Payment page (web) — works for both guests and authenticated users
Route::get('/payment/{order_number}', [\App\Http\Controllers\Inertia\PaymentController::class, 'show'])->name('user.payment');
Route::get('/payment/{order_number}/callback', [\App\Http\Controllers\Inertia\PaymentController::class, 'callback'])->name('payment.callback');


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

// user Auth routes
Route::middleware('auth:web')->group(function () {
    Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user.profile');

    Route::post('/wishlist/add/{product}', [\App\Http\Controllers\Inertia\WishListController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{product}', [\App\Http\Controllers\Inertia\WishListController::class, 'remove'])->name('wishlist.remove');
    Route::post('/reviews', [\App\Http\Controllers\Inertia\ReviewController::class, 'store'])->name('reviews.store');

    //    Route::get('/user_wishlist', [UserProfileController::class, 'userWishList'])->name('user.wishlist');
    // Route::get('/user_info', [UserProfileController::class, 'userInfo'])->name('user.info');
    // Route::get('/user_addresses', [UserProfileController::class, 'userAddresses'])->name('user.addresses');
    // Route::get('/user_addresses/create', [UserProfileController::class, 'userAddressesCreate'])->name('create.address');
    // Route::post('/user_addresses/store', [UserProfileController::class, 'userAddressesStore'])->name('store.address');
    // Route::get('/user_addresses/{addressId}/edit', [UserProfileController::class, 'userAddressesEdit'])->name('edit.address');
    // Route::put('/user_addresses/{addressId}/update', [UserProfileController::class, 'userAddressesUpdate'])->name('update.address');
    // Route::delete('/user_addresses/{addressId}/delete', [UserProfileController::class, 'userAddressesDestroy'])->name('delete.address');

    Route::prefix('user/addresses')->name('user.addresses.')->group(function () {
        Route::post('/', [UserProfileController::class, 'userAddressesStore'])->name('store');
        Route::put('/{id}', [UserProfileController::class, 'userAddressesUpdate'])->name('update');
        Route::delete('/{id}', [UserProfileController::class, 'userAddressesDestroy'])->name('destroy');
        Route::post('/set-main/{id}', [UserProfileController::class, 'setMainAddress'])->name('setMain');
    });
    /*new*/
    Route::post('/user_addresses/{address}/set_main', [UserProfileController::class, 'setMainAddress'])->name('user.addresses.set_main');


    Route::get('/user_change_password', [UserProfileController::class, 'changePasswordView'])->name('user_password');
    Route::put('/user_update_info/update', [UserProfileController::class, 'updatePassword'])->name('update_password');
    Route::put('/user_normal_info/update', [UserProfileController::class, 'updateUserInfo'])->name('update_user_info');
    Route::post('/user_normal_info/verify_to_update', [UserProfileController::class, 'verify_to_update'])->name('verify_to_update');
    Route::post('/user_normal_info/resendVerifyCode_to_update', [UserProfileController::class, 'resendVerifyCodeToupdate'])->name('resendVerifyCode_to_update');


    // /* مشاهدة الطلب */
    // Route::get('/user_orders/{number}', [UserOrdersController::class, 'showOrder'])->name('user.orders');
    // /* الطلبات */
    // Route::get('/user_main_orders', [UserOrdersController::class, 'mainOrders'])->name('user.main.orders');
    // /* حذف طلب */
    // Route::delete('/user_orders/delete', [UserOrdersController::class, 'destroy'])->name('order.delete');


    // /* المرتجعات */
    Route::get('/user_return_orders', [\App\Http\Controllers\Inertia\ReturnProductsController::class, 'index'])->name('user.return_products');
    Route::post('/user_return_orders/store', [\App\Http\Controllers\Inertia\ReturnProductsController::class, 'store'])->name('user.return_products.store');


    #################################################--Comments Routes
    // Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');
});
// Route::get('/user/payment/{order_number}', [\App\Http\Controllers\Front\PaymentController::class, 'index'])->name('user.payment');
/*عملية الدفع*/
// Route::get('/user_orders/{number}/payment/callback', [\App\Http\Controllers\Front\PaymentController::class, 'callback'])->name('payment.callback');
//Route::get('/user_orders/{number}/payment/callback', [\App\Http\Controllers\Front\PaymentController::class, 'callback'])->name('payment.callback');

require __DIR__ . '/dashboard.php';
