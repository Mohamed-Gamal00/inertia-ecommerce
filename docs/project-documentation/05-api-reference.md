# API Reference

## API Overview

The application provides a comprehensive REST API for mobile applications and third-party integrations. All API endpoints are prefixed with `/api` and protected by the `changeLanguage` middleware.

## Base URL

```
{APP_URL}/api
```

## Authentication

### Authentication Methods

1. **Laravel Sanctum** - Token-based authentication
   - Header: `Authorization: Bearer {token}`
   - Guard: `auth:user`

2. **Guest Access** - Cookie-based guest identification
   - Header: `X-Guest-Id: {guest_id}` (for guest operations)
   - Middleware: `guest.header`

## Response Format

All API responses follow a consistent structure via `ApiResponse` helper:

```json
{
    "status_code": 200,
    "message": "Success message",
    "data": {
        // Response data
    }
}
```

## API Endpoint Inventory

### Authentication Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| POST | `/api/register` | UserAuthController@register | No | User registration |
| POST | `/api/verify-code` | UserAuthController@verifyCode | No | Verify registration code |
| POST | `/api/resend-verify-code` | UserAuthController@resendVerifyCode | No | Resend verification SMS |
| POST | `/api/login` | UserAuthController@login | No | User login |
| POST | `/api/forget-password` | UserAuthController@forgetPassword | No | Request password reset |
| POST | `/api/reset-password` | UserAuthController@resetPassword | No | Reset password with code |
| POST | `/api/logout` | UserAuthController@logout | Yes (auth:user) | User logout |

#### POST /api/register

**Request Body**:
```json
{
    "first_name": "string|required",
    "family_name": "string|required",
    "phone_number": "string|required|unique",
    "email": "email|required|unique",
    "password": "string|required|min:6|confirmed",
    "password_confirmation": "string|required",
    "address": "string|nullable",
    "city_id": "integer|exists:cities,id"
}
```

**Response** (200):
```json
{
    "status_code": 200,
    "message": "رمز التحقق الخاص بحسابك 1111",
    "data": {
        "verification_required": true,
        "user_id": 123
    }
}
```

**File**: `app/Http/Controllers/Api/UserAuthController.php`

#### POST /api/verify-code

**Request Body**:
```json
{
    "user_id": "integer|required",
    "code": "string|required"
}
```

**Response** (200 - Success):
```json
{
    "status_code": 200,
    "message": "Verification successful",
    "data": {
        "token": "1|laravel_sanctum_token..."
    }
}
```

**Response** (403 - Invalid Code):
```json
{
    "status_code": 403,
    "message": "Invalid verification code",
    "data": null
}
```

#### POST /api/login

**Request Body**:
```json
{
    "phone_number": "string|required",
    "password": "string|required"
}
```

**Response** (200):
```json
{
    "status_code": 200,
    "message": "Login Successfully",
    "data": {
        "token": "2|sanctum_token..."
    }
}
```

### User Profile Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/user-info` | PersonalInfoController@getUserInfo | Yes | Get user profile |
| POST | `/api/change-personal-info` | PersonalInfoController@changePersonalInfo | Yes | Update profile |
| POST | `/api/change-password` | PersonalInfoController@changePassword | Yes | Change password |
| POST | `/api/change-profile-image` | PersonalInfoController@changeProfileImage | Yes | Update avatar |

**File**: `app/Http/Controllers/Api/Profile/PersonalInfoController.php`

### User Addresses Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/user-addresses` | UserAddressesController@getAllAddresses | Yes | List user addresses |
| GET | `/api/user-country-cities` | UserAddressesController@getUserCities | Yes | Get cities for user's country |
| POST | `/api/create-address` | UserAddressesController@createAddress | Yes | Create new address |
| POST | `/api/update-address/{id}` | UserAddressesController@updateAddress | Yes | Update address |
| DELETE | `/api/delete-address/{id}` | UserAddressesController@deleteAddress | Yes | Delete address |
| POST | `/api/main-address/{id}` | UserAddressesController@setMainAddress | Yes | Set default address |

**File**: `app/Http/Controllers/Api/Profile/UserAddressesController.php`

### Product Catalog Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/get-top-products` | TopSellingProductsController@topProducts | No | Get featured top products |
| GET | `/api/get-all-top-products` | TopSellingProductsController@allTopProducts | No | Get all top-selling products |
| GET | `/api/get-latest-products` | LatestProductController@latestProducts | No | Get latest products (limited) |
| GET | `/api/get-all-latest-products` | LatestProductController@allLatestProducts | No | Get all latest products |
| GET | `/api/products/{category_id}` | AllProductsController | No | Get products by category |
| GET | `/api/product-details/{id}` | ProductDetailsController@getProductDetails | No | Get product details |
| GET | `/api/product-colors/{id}` | ProductDetailsController@productColors | No | Get product color options |
| GET | `/api/product-features/{id}` | ProductDetailsController@productFeatures | No | Get product features/specs |
| GET | `/api/related-products/{id}` | ProductDetailsController@relatedProducts | No | Get related products |

#### GET /api/product-details/{id}

**Response** (200):
```json
{
    "status_code": 200,
    "message": "",
    "data": {
        "product": {
            "id": 1,
            "name": "Product Name",
            "name_en": "Product Name EN",
            "description": "...",
            "price": "100.00",
            "discount_price": "80.00",
            "image_url": "https://...",
            "images": [
                {"image_url": "https://..."}
            ],
            "colors": [...],
            "features": [...],
            "category": {...},
            "quantity": 10
        }
    }
}
```

**File**: `app/Http/Controllers/Api/ProductDetailsController.php`

### Category Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/get-main-categories` | MainCategoriesController@mainCategories | No | Get main categories (limited) |
| GET | `/api/get-all-categories` | MainCategoriesController@allMainCategories | No | Get all main categories |
| GET | `/api/get-sub-categories/{mainCategory}` | MainCategoriesController@subMainCategories | No | Get subcategories |

### Search & Filter Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/search` | SearchProductController@search | No | Search products by keyword |
| GET | `/api/filter` | FilterProductsController@filterProducts | No | Filter products |

**Query Parameters for /api/search**:
- `q`: Search query string

**Query Parameters for /api/filter**:
- `category_id`: Filter by category
- `company_id`: Filter by brand/company
- `color_id`: Filter by color
- `min_price`: Minimum price
- `max_price`: Maximum price

### Cart Endpoints (Authenticated Users)

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/cart` | CartController@index | Yes | Get cart items |
| POST | `/api/cart/add` | CartController@store | Yes | Add item to cart |
| POST | `/api/cart/update/{id}` | CartController@update | Yes | Update cart item quantity |
| POST | `/api/cart/delete/{id}` | CartController@destroy | Yes | Remove item from cart |
| GET | `/api/cart/count` | CartController@getCartCount | Yes | Get cart item count |
| GET | `/api/cart/total-price` | CartController@getTotalPrice | Yes | Get cart total price |
| GET | `/api/cart/total-quantity` | CartController@getTotalQuantity | Yes | Get total quantity |

**File**: `app/Http/Controllers/Api/CartController.php`

#### POST /api/cart/add

**Request Body**:
```json
{
    "product_id": "integer|required|exists:products,id",
    "quantity": "integer|nullable|min:1",
    "color_id": "integer|nullable|exists:colors,id"
}
```

**Response** (200):
```json
{
    "status_code": 200,
    "message": "Product added to cart",
    "data": {
        "cart_items": [...]
    }
}
```

### Guest Cart Endpoints

| Method | Endpoint | Controller | Auth Required | Middleware | Purpose |
|--------|----------|------------|---------------|------------|---------|
| GET | `/api/guest-cart` | GuestCartController@guestIndex | No | guest.header | Get guest cart |
| POST | `/api/guest-cart/add` | GuestCartController@guestStore | No | guest.header | Add to guest cart |
| POST | `/api/guest-cart/update/{id}` | GuestCartController@guestUpdate | No | guest.header | Update guest cart |
| POST | `/api/guest-cart/delete/{id}` | GuestCartController@guestDestroy | No | guest.header | Remove from guest cart |
| GET | `/api/guest-cart/count` | GuestCartController@guestGetCartCount | No | guest.header | Get guest cart count |
| GET | `/api/guest-cart/total-price` | GuestCartController@guestGetTotalPrice | No | guest.header | Get guest cart total |
| GET | `/api/guest-cart/total-quantity` | GuestCartController@guestGetTotalQuantity | No | guest.header | Get total quantity |

**File**: `app/Http/Controllers/Api/guest/GuestCartController.php`

### Checkout Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| POST | `/api/checkout` | CheckoutController@usercheckout | Yes | User checkout |
| POST | `/api/guest-checkout` | guest\CheckoutController@guestCheckout | No (guest.header) | Guest checkout |
| GET | `/api/shipping-info` | CheckoutController@shippingInfo | No | Get shipping options |

**File**: 
- `app/Http/Controllers/Api/CheckoutController.php`
- `app/Http/Controllers/Api/guest/CheckoutController.php`

#### POST /api/checkout

**Request Body**:
```json
{
    "payment_method": "string|required|in:cash_on_delivery,card_payment",
    "note": "string|nullable",
    "join_news": "boolean|nullable",
    "pickup_from_store": "boolean|nullable",
    "fixed_shipping": "boolean|nullable",
    "shipping_based_on_weight": "boolean|nullable",
    "shipping_based_on_city": "boolean|nullable",
    "user_address": "integer|nullable|exists:user_addresses,id",
    "addr": {
        "shipping": {
            "first_name": "string|required_without:user_address",
            "last_name": "string",
            "phone_number": "string",
            "country_id": "integer|exists:countries,id",
            "city_id": "integer|exists:cities,id",
            "address": "string"
        }
    }
}
```

**Response** (201 - Card Payment):
```json
{
    "redirect": "https://domain.com/api/payment-page/{order_number}"
}
```

**Response** (201 - Cash on Delivery):
```json
{
    "redirect": "https://domain.com",
    "message": "تم إتمام الطلب بنجاح"
}
```

### Discount Code Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| POST | `/api/check-discount` | CheckDiscountController | Yes | Validate discount code |
| POST | `/api/guest-check-discount` | guest\GuestCheckDiscountController | No (guest.header) | Validate discount for guest |

### Order Management Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/user_orders` | UserOrdersController@mainOrders | Yes | Get user's orders |
| GET | `/api/user_show_order/{number}` | UserOrdersController@showOrder | Yes | Get order details |
| POST | `/api/user-orders/delete` | UserOrdersController@destroy | Yes | Delete order |
| GET | `/api/user-return-orders` | UserOrdersController@returns | Yes | Get return orders |
| POST | `/api/user-return-orders/store` | UserOrdersController@store | Yes | Create return request |

**File**: `app/Http/Controllers/Api/UserOrdersController.php`

### Guest Order Endpoints

| Method | Endpoint | Controller | Auth Required | Middleware | Purpose |
|--------|----------|------------|---------------|------------|---------|
| GET | `/api/guest-orders` | guest\GuestOrdersController@mainOrders | No | guest.header | Get guest orders |
| GET | `/api/guest-order/{number}` | guest\GuestOrdersController@showOrder | No | guest.header | Get guest order details |
| POST | `/api/guest-order/delete` | guest\GuestOrdersController@destroy | No | guest.header | Delete guest order |
| GET | `/api/guest-return-orders` | guest\GuestOrdersController@returns | No | guest.header | Get guest returns |
| POST | `/api/guest-return-orders/store` | guest\GuestOrdersController@store | No | guest.header | Create guest return |

**File**: `app/Http/Controllers/Api/guest/GuestOrdersController.php`

### Wishlist (Favorites) Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/all-user-fav-products` | GetAllFavProductsController@userFavProducts | Yes | Get user favorites |
| POST | `/api/user-fav-product-add-or-delete` | AddToFavProductsController@userAddFavProducts | Yes | Toggle user favorite |
| GET | `/api/all-guest-fav-products` | GetAllFavProductsController@guestFavProducts | No | Get guest favorites |
| POST | `/api/guest-fav-product-add-or-delete` | AddToFavProductsController@guestAddFavProducts | No | Toggle guest favorite |
| GET | `/api/check-if-auth` | AddToFavProductsController@checkIfAuth | Yes | Check auth status |
| GET | `/api/check-if-product-exists` | AddToFavProductsController@checkIfProductExists | No | Check if product exists |

**Files**:
- `app/Http/Controllers/Api/GetAllFavProductsController.php`
- `app/Http/Controllers/Api/AddToFavProductsController.php`

### Banners & Promotions

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/get-header-banners` | AllBannersController@headerBanners | No | Get header banners (limited) |
| GET | `/api/get-all-banners` | AllBannersController@allBanners | No | Get all banners |
| GET | `/api/discounts` | DiscountsController@discounts | No | Get active discounts (limited) |
| GET | `/api/all-discounts` | DiscountsController@allDiscounts | No | Get all discounts |

### Utility Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/get-cities` | CitiesController@allCities | No | Get all cities |
| GET | `/api/settings` | SettingsController@settings | No | Get application settings |
| GET | `/api/colors` | ColorsController | No | Get all colors |
| GET | `/api/brands` | BrandsController | No | Get all brands/companies |
| GET | `/api/default-currency` | CurrenciesController@defaultCurrency | No | Get default currency |
| GET | `/api/all-currencies` | CurrenciesController@allCurrencies | No | Get all currencies |
| POST | `/api/contact-us` | ContactUsController@sendMessage | No | Send contact message |
| POST | `/api/create-guest` | GuestController@createGuest | No | Create guest record |

### Special Order Types

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| POST | `/api/store-bulk-order` | BulkOrderController@store | No | Submit bulk order inquiry |
| POST | `/api/store-represintative-order` | RepresentativeOrderController@storeorder | No | Submit representative order |

### Static Content

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/static-pages` | StaticPagesController@static_pages | No | Get static pages |
| GET | `/api/common-questions` | StaticPagesController@common_questions | No | Get FAQ |

### Payment Endpoints

| Method | Endpoint | Controller | Auth Required | Purpose |
|--------|----------|------------|---------------|---------|
| GET | `/api/payment-page/{order_number}` | PaymentController@index | No | Display payment page |
| GET | `/api/payment-page/{number}/payment/callback` | PaymentController@callback | No | Payment gateway callback |

**File**: `app/Http/Controllers/Api/PaymentController.php`

#### Payment Flow

1. User completes checkout with `payment_method: card_payment`
2. API redirects to `/api/payment-page/{order_number}`
3. Payment page displays Moyasar payment form
4. After payment, Moyasar redirects to `/api/payment-page/{number}/payment/callback?id={payment_id}`
5. Backend verifies payment status with Moyasar API
6. Order `payment_status` updated to `paid` or `failed`

## API Resource Transformations

### ProductsResource

**File**: `app/Http/Resources/ProductsResource.php`

**Output Structure** (INFERRED):
```json
{
    "id": 1,
    "name": "Product Name",
    "name_en": "Product Name EN",
    "price": "100.00",
    "discount_price": "80.00",
    "image_url": "https://...",
    "category": {...},
    "colors": [...],
    "images": [...]
}
```

### CartResource

**File**: `app/Http/Resources/CartResource.php`

**Output Structure** (INFERRED):
```json
{
    "id": "uuid",
    "product_id": 1,
    "product_name": "...",
    "quantity": 2,
    "price": "100.00",
    "color": {...},
    "total": "200.00"
}
```

### OrderResource

**File**: `app/Http/Resources/OrderResource.php`

**Output Structure** (INFERRED):
```json
{
    "id": 1,
    "number": "2026000001",
    "status": "pending",
    "payment_status": "unpaid",
    "total_price": "250.00",
    "shipping_price": "20.00",
    "items": [...],
    "address": {...},
    "created_at": "2026-01-01T00:00:00.000000Z"
}
```

## Error Responses

### Validation Errors (422)
```json
{
    "status_code": 422,
    "message": "Validation Error",
    "data": {
        "field_name": ["Error message"]
    }
}
```

### Authentication Errors (401)
```json
{
    "status_code": 401,
    "message": "Login Failed",
    "data": []
}
```

### Not Found (404)
```json
{
    "status_code": 404,
    "message": "Resource not found",
    "data": null
}
```

### Server Errors (500)
```json
{
    "status_code": 500,
    "message": "Internal server error",
    "data": null
}
```

## Rate Limiting

**UNKNOWN**: No explicit rate limiting detected in the codebase. Laravel's default throttle middleware may be applied.

## API Versioning

**Current Status**: No API versioning implemented. All endpoints are at `/api` base path.

**RECOMMENDED**: Implement versioning (e.g., `/api/v1/`) before making breaking changes.

## Pagination

**Standard Laravel Pagination** used for list endpoints.

**Response Structure**:
```json
{
    "data": [...],
    "links": {
        "first": "...",
        "last": "...",
        "prev": null,
        "next": "..."
    },
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 75
    }
}
```

## Language Handling

**Middleware**: `changeLanguage`

**Mechanism** (INFERRED):
- Accept-Language header or query parameter
- Sets application locale
- Returns localized content

**Bilingual Fields**:
- Most models have `name` (Arabic) and `name_en` (English)
- Frontend determines which to display based on locale

## Notable API Behaviors

### 1. Guest Identification

Guest operations require `X-Guest-Id` header with guest ID obtained from `/api/create-guest`.

### 2. Cart Cookie Handling

API cart operations use `getCookieIdApi()` which:
- For authenticated users: Finds existing cart by `user_id`
- For guests: Finds cart by `guest_id`
- Creates new UUID if none exists

### 3. Discount Code Session

Applied discount codes are stored in session:
- `session('applied_discount_code_id')`
- Applied during checkout

### 4. Automatic Stock Management

When an order is created:
- Product quantities are decremented
- Products with quantity ≤ 1 are automatically archived (`status = 'archived'`)

## Missing API Documentation

The following endpoints exist but detailed documentation could not be fully determined from the code:
- Some filter parameter options
- Complete validation rules for all endpoints
- Specific error scenarios for complex operations

## API Testing

**RECOMMENDED**: No API tests detected in the repository. Implement API tests using PHPUnit or Pest for endpoint validation.
