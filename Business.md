# Dabberhaly — Project Overview

**Dabberhaly** is an Egyptian e-commerce platform for practical household essentials.
Built with **Laravel 10**, **Inertia.js**, **Vue 3**, and **Vuetify 3**.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 10 (PHP) |
| Frontend | Vue 3 + Inertia.js |
| UI Library | Vuetify 3 (dabbarhaTheme) |
| Styling | Custom CSS (Vanilla Latte theme) |
| Auth | Laravel session-based (web guard) + Sanctum (API) |
| Payment | Moyasar gateway |
| Search/Locale | Arabic/English (vue-i18n + Laravel locale) |
| Routing (JS) | Ziggy |

---

## Brand Theme

Theme name: **dabbarhaTheme** (Vuetify)

| Token | Hex | Usage |
|-------|-----|-------|
| Mocha Brown (primary) | `#76543D` | Buttons, links, nav, prices |
| Caramel (secondary) | `#C69763` | Accents, badges, hover states |
| Vanilla Cream (background) | `#F7F0E5` | Page backgrounds |
| Pure White (surface) | `#FFFFFF` | Cards, forms |
| Primary Text | `#302F2B` | Headings, body |
| Secondary Text | `#77736B` | Descriptions, metadata |
| Border Beige | `#D7CDBD` | Card borders, dividers |

CSS variables are defined in `resources/css/app.css` and loaded globally via `resources/js/app.js`.

---

## Project Structure

```
app/
  Http/Controllers/
    Inertia/        ← Customer-facing page controllers
    Api/            ← Mobile/API controllers
    Dashboard/      ← Admin panel controllers
  Models/           ← Eloquent models
  Repositories/     ← Cart, etc.
  Services/         ← CheckoutServices
resources/
  js/
    Pages/          ← Vue pages (Inertia)
    layouts/        ← AppLayout, AppHeader, AppFooter
    components/     ← Shared components, home_page/
  css/app.css       ← Brand styles
routes/
  web.php           ← Customer-facing routes
  api.php           ← API routes
  dashboard.php     ← Admin routes (/admin prefix)
```

---

## Customer-Facing Pages & Routes

### Public (no auth required)

| Route | Controller | Page |
|-------|-----------|------|
| `GET /` | HomeController | Home.vue |
| `GET /products` | ProductController | Products/Index.vue |
| `GET /products/{slug}` | ProductController | Products/Show.vue |
| `GET /categories` | CategoryController | Categories/Index.vue |
| `GET /categories/{slug}` | CategoryController | Categories/Show.vue |
| `GET /brands` | BrandsController | Brands/Index.vue |
| `GET /brands/{id}` | BrandsController | Brands/Show.vue |
| `GET /offers` | OfferProductController | Offers/Index.vue |
| `GET /compare` | CompareController | Compare.vue |
| `GET /search` | SearchController | (JSON response) |
| `GET /contact-us` | ContactUsController | ContactUs/Index.vue |
| `GET /bulk-order` | BulkOrderController | BulkOrder/Index.vue |
| `GET /representative-order` | RepresentativeOrderController | RepresentativeOrder/Index.vue |
| `GET /faq` | StaticPageController | FAQ page |
| `GET /shipping-policy` | StaticPageController | Shipping Policy |
| `GET /terms-conditions` | StaticPageController | Terms |
| `GET /privacy-policy` | StaticPageController | Privacy Policy |
| `GET /exchanges-returns` | StaticPageController | Returns Policy |

### Auth Pages

| Route | Controller | Page |
|-------|-----------|------|
| `GET /login` | UserAuthController | Login.vue |
| `GET /register` | UserAuthController | Register.vue |
| `GET /forgot-password` | UserAuthController | ForgotPassword.vue |
| `GET /reset-password` | UserAuthController | ResetPassword.vue |

### Cart (guest + authenticated, cookie-based)

| Route | Action |
|-------|--------|
| `POST /cart/add` | Add product to cart |
| `GET /cart` | Get cart items (JSON) |
| `PATCH /cart/{id}` | Update quantity |
| `DELETE /cart/{id}` | Remove item |

Cart is cookie-based — works for both guests and logged-in users.
The `Cart::getCookieId()` method identifies the session.

### Checkout & Payment (guest + authenticated)

| Route | Action |
|-------|--------|
| `GET /checkout` | Render checkout page |
| `POST /checkout` | Submit order |
| `POST /checkout/apply-discount` | Apply discount code |
| `GET /payment/{order_number}` | Render Moyasar payment form |
| `GET /payment/{order_number}/callback` | Handle payment result |

### Authenticated User Routes

| Route | Action |
|-------|--------|
| `GET /user-profile` | Profile dashboard (orders, addresses, wishlist) |
| `POST /wishlist/add/{product}` | Add to wishlist |
| `POST /wishlist/remove/{product}` | Remove from wishlist |
| `POST /reviews` | Submit product review |
| `GET /user_return_orders` | View return requests |
| `POST /user_return_orders/store` | Submit return request |
| `GET /account` | Account page |
| User address CRUD | `/user/addresses/*` |
| Change password | `/user_change_password` |
| Update profile info | `/user_normal_info/update` |

---

## Core Flows

### Guest Shopping Flow

1. Browse home page → product swipers, top offers, banners
2. Navigate to Products or Categories → filter by price, category, sort
3. View product detail → images, features, reviews
4. Add to cart (cookie-based, no login needed)
5. Go to checkout → fill billing address + email
6. Select payment method: **cash on delivery** or **card payment**
7. If card → redirected to Moyasar payment page
8. Payment callback → order marked paid/failed → Success or Failed page

### Registered User Shopping Flow

1. Register → verify via OTP code → login
2. Same browsing/cart flow as guest
3. At checkout → can select a saved address or add a new one
4. Apply discount code (registered users only)
5. Same payment flow as guest

### Authentication Flow

1. `POST /register` → creates user, sends OTP
2. `POST /verify` → verifies OTP, activates account
3. `POST /login` → authenticates, creates session
4. Forgot password → sends reset code → `POST /update-password`
5. Logout → destroys session

### Checkout Flow (detail)

1. `GET /checkout`:
   - Redirect to home if cart is empty
   - Load cart items, countries, cities, shipping config
   - Load saved addresses if authenticated
   - Load applied discount if any
2. `POST /checkout/apply-discount`:
   - Requires authentication
   - Validates code: active, has remaining uses
   - Checks if code applies to cart items (global or product-specific)
   - Applies discount amount to matching cart items
   - Stores discount in session for order creation
3. `POST /checkout` (via `CheckoutServices`):
   - Validates address (existing or new)
   - Validates payment method (`cash_on_delivery` | `card_payment`)
   - Calculates shipping price
   - Creates `Order` + `OrderItems` + `OrderAddress`
   - Clears cart after order creation
   - If card payment → redirect to `/payment/{order_number}`
   - If cash → redirect to success

### Payment Flow (Moyasar)

1. `GET /payment/{order_number}` → renders form with Moyasar publishable key
2. User submits card via Moyasar.js (client-side)
3. Moyasar redirects to `GET /payment/{order_number}/callback?id={payment_id}`
4. Callback fetches payment status from Moyasar API
5. Creates `PaymentTransaction` record
6. Updates `Order.payment_status` to `paid` or `failed`
7. If paid → notifies admins via email
8. Renders `Payment/Success.vue` or `Payment/Failed.vue`

---

## Home Page Data

`HomeController::index()` passes to `Home.vue`:

| Prop | Source | Usage |
|------|--------|-------|
| `products` | Latest 10 products | Product swipers |
| `banners` | `HeaderBanner` table | Upper banner carousel |
| `homeDesigns` | `Design` model (page_name=home) | Band left/right images + TV banner |
| `topOffers` | `Design` model (top_offer_1..5) | Top offers section |
| `newProductsBanner` | `Design` model (new_products_banner) | New products section banner |

Home page sections (in order):
1. `UpperPanner` — header banner carousel
2. `TheFeatures` — feature highlights
3. `TopCategories` — top categories
4. `TopOffers` — promotional offer images
5. `ProductsSwiper` — flash deals
6. `NewProducts` — latest products + banner
7. `QualityFeatuers` — quality/trust icons
8. `ProductsSwiper` — top mobiles
9. Band images (left + right, from Designs)
10. `ProductsSwiper` — household supplies
11. TV banner image (from Designs)

---

## Design / Banner System

Admins manage page images via **Dashboard → Designs** (`/admin/designs`).

The `designs` table stores:

| title | page_name | Description |
|-------|-----------|-------------|
| `home_band_left` | home | Left mid-section banner |
| `home_band_right` | home | Right mid-section banner |
| `home_tv_banner` | home | Full-width TV banner |
| `top_offer_1..5` | home | Top offers section images |
| `new_products_banner` | home | New products section sidebar image |

If no image is uploaded, static fallback assets from `resources/js/assets/images/` are used.

---

## Admin Dashboard

Prefix: `/admin/` — protected by `admin` middleware.

| Section | Route | Purpose |
|---------|-------|---------|
| Dashboard | `/admin/` | Stats overview |
| Products | `/admin/products` | CRUD, images, features, trash/restore |
| Categories | `/admin/main_categories` | Category tree management |
| Orders | `/admin/orders` | View, update status, delete |
| Return Orders | `/admin/return_orders` | Manage customer returns |
| Payments | `/admin/payments` | View Moyasar transactions |
| Clients | `/admin/clients` | Manage customer accounts |
| Admins | `/admin/admins` | Admin accounts and roles |
| Designs | `/admin/designs` | Page banners and images |
| Banners | `/admin/banners` | Header banner carousel |
| Discount Codes | `/admin/discount_code` | Coupon management |
| Shipping | `/admin/shipping_types` | Shipping methods and pricing |
| Countries/Cities | `/admin/countries`, `/admin/cities` | Location data |
| Currencies | `/admin/currencies` | Currency setup |
| Advertisements | `/admin/advertisements` | Animated marquee ads |
| Static Pages | `/admin/pages` | Terms, privacy, FAQ content |
| Bulk Orders | `/admin/bulk_orders` | Wholesale requests |
| Representative Orders | `/admin/representatives_orders` | Distributor requests |
| Contact Messages | `/admin/contact_us_view` | Customer contact submissions |
| Reports | `/admin/reports` | Sales analytics |
| Settings | `/admin/front_settings` | Site-wide settings (Moyasar keys, etc.) |
| Colors | `/admin/colors` | Product color variants |

Admin login: `/admin/login`

---

## Key Models & Relationships

### Product
- Belongs to: `MainCategory` (parent), `Company`, `ProductAvailability`
- Has many: `ProductImage`, `ProductFeature`, `CartItem`, `OrderItem`, `Comment`
- Many-to-many: `Color`, `DiscountCode`, `Order` (via order_items)
- Scope: `withIsInWishlist($user)` — adds `is_in_wishlist` boolean
- Soft deletes enabled
- `image_url` appended accessor

### Order
- Belongs to: `User` (nullable), `Guest` (nullable), `DiscountCode`, `OrderStatus`
- Has many: `OrderItem`, `OrderAddress`, `PaymentTransaction`
- Auto-generates order number: `YYYY000001`, incrementing per year
- Key statuses: `payment_status` (paid/failed/pending), `status`, `return_order`

### User
- Has many: `Order`, `UserAddress`, `Comment`
- Many-to-many: `Product` (wishlist via `wishlist_products_user`)
- OTP verification via `User_verfication`

### Cart
- Identified by `cookie_id` (works for guests too)
- Belongs to: `User` (nullable), `Product`

### Design
- `title` + `page_name` combination uniquely identifies each design slot
- `image_url` accessor returns storage URL or default asset

### DiscountCode
- Can be global or product-specific
- Has `discount_type`: `percentage` or `fixed`
- Tracks usage via `number_of_used` and `UserDiscountCode` pivot

---

## API (Mobile/External)

Base: `/api/` — uses Sanctum (`auth:user` guard).

Supports full guest experience via `guest.header` middleware (cookie-based).

Key endpoint groups:
- Auth: register, login, OTP verify, forgot/reset password
- Products: list, details, features, colors, related, search, filter
- Cart: user cart + guest cart (separate endpoints)
- Checkout: user checkout + guest checkout
- Orders: view, delete, returns
- Favorites: user + guest wishlist
- Profile: personal info, password, addresses
- Static: settings, categories, banners, currencies, cities

---

## Localization

- Languages: **Arabic** (default) and **English**
- Switched via `POST /locale/{lang}` (stores in session)
- Vuetify locale: Arabic RTL
- Products have `name` (Arabic) and `name_en` (English) fields
- `getCurrentNameLangAttribute` returns the correct field by locale
