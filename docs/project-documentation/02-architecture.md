# System Architecture

## Architectural Style

The application follows a **Layered Monolithic Architecture** with clear separation of concerns:

```
┌─────────────────────────────────────────────────────────┐
│              Frontend Layer (Dual Interface)            │
├────────────────────────┬────────────────────────────────┤
│   Inertia.js/Vue 3     │      REST API (Mobile)         │
│   (Web Application)    │      (JSON Responses)          │
└────────────────────────┴────────────────────────────────┘
                         │
┌────────────────────────┴────────────────────────────────┐
│              Middleware Layer                            │
│  (Authentication, Language, Validation, CSRF)            │
└──────────────────────────────────────────────────────────┘
                         │
┌────────────────────────┴────────────────────────────────┐
│              Controller Layer                            │
│  (Request Handling, Response Formatting)                 │
└──────────────────────────────────────────────────────────┘
                         │
┌────────────────────────┴────────────────────────────────┐
│              Service Layer                               │
│  (Business Logic, External Integrations)                 │
└──────────────────────────────────────────────────────────┘
                         │
┌────────────────────────┴────────────────────────────────┐
│              Repository Layer (Partial)                  │
│  (Data Access Abstraction)                               │
└──────────────────────────────────────────────────────────┘
                         │
┌────────────────────────┴────────────────────────────────┐
│              Model Layer (Eloquent ORM)                  │
│  (Database Entities, Relationships)                      │
└──────────────────────────────────────────────────────────┘
                         │
┌────────────────────────┴────────────────────────────────┐
│              Database Layer (MySQL)                      │
└──────────────────────────────────────────────────────────┘
```

## Design Patterns

### 1. Repository Pattern (Partial Implementation)

**Location**: `app/Repositories/`

**Evidence**:
- `app/Repositories/Cart/CartRepository.php` - Cart data access
- `app/Repositories/Admin/AdminRepository.php` - Admin management
- `app/Repositories/Category/CategoryRepository.php` - Category operations

**Usage**: 
The repository pattern is **inconsistently applied**. It exists for:
- Cart operations
- Admin management
- Category management
- Advertisements
- Cities

**Non-Repository Approach**: Many controllers directly use Eloquent models without repositories (e.g., `ProductDetailsController`, `OrderController`)

### 2. Service Layer Pattern

**Location**: `app/Services/`

**Implemented Services**:

1. **CheckoutServices** (`app/Services/CheckOut/CheckoutServices.php`)
   - Order creation
   - Shipping calculation
   - Address management
   - Payment method handling
   - Cart merging for authenticated users
   
2. **UserService** (`app/Services/UserService.php`)
   - User registration
   - Verification code management
   - User address creation

3. **VerificationServices** (`app/Services/VerificationServices.php`)
   - OTP code generation
   - Code validation
   - SMS message formatting

4. **CartServices** (`app/Services/Cart/CartServices.php`)
   - Cart operations abstraction

5. **CheckDiscountService** (`app/Services/Discount/CheckDiscountService.php`)
   - Discount code validation

6. **SMS Gateway Services** (`app/Services/SMSGateways/`)
   - `TelephoneVerification.php` - SMS sending
   - `moraSms.php` - SMS provider integration

**Pattern**: Services encapsulate complex business logic and coordinate between multiple models and external services.

### 3. API Resource Pattern (Transformers)

**Location**: `app/Http/Resources/`

**Purpose**: Transform Eloquent models into consistent JSON structures for API responses.

**Examples**:
- `ProductsResource.php` - Product list formatting
- `ProductDetailsResource.php` - Detailed product view
- `CartResource.php` - Cart item formatting
- `OrderResource.php` - Order data transformation
- `UserInfoResource.php` - User profile data

**Usage**: Applied consistently across API controllers for data presentation layer.

### 4. Form Request Validation

**Location**: `app/Http/Requests/`

**Structure**:
```
Requests/
├── Api/                    # API-specific validation
├── Auth/                   # Authentication requests
├── Checkout/               # Checkout validation
├── Dashboard/              # Admin dashboard requests
└── profile/                # User profile requests
```

**Purpose**: Centralize validation logic separate from controllers.

### 5. Multi-Guard Authentication

**Configuration**: `config/auth.php`

**Guards Defined**:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
    'user' => [
        'driver' => 'sanctum',
        'provider' => 'users',
    ],
],
```

**Implementation**:
- **`web` guard**: Session-based authentication for Inertia.js frontend
- **`admin` guard**: Session-based authentication for admin dashboard
- **`user` guard**: Sanctum token-based authentication for API

### 6. Helper Functions

**Location**: `app/Helper/`

**Helpers**:
1. **ApiResponse.php** - Standardized API response formatting
2. **Helper.php** - General utility functions (VERIFIED exists)
3. **ImageCustomization.php** - Image processing utilities
4. **TextTranslate.php** - Translation helper functions

### 7. Global Scopes (Eloquent)

**Example**: `app/Models/Cart.php`

```php
protected static function booted()
{
    static::addGlobalScope('cookie_id', function (Builder $builder) {
        $builder->where('cookie_id', '=', Cart::getCookieId());
    });
}
```

**Usage**: Automatically filters cart queries by cookie ID to ensure users only see their own cart items.

## Architectural Layers

### Presentation Layer

#### 1. Inertia.js Controllers
**Location**: `app/Http/Controllers/Inertia/`

**Responsibilities**:
- Render Vue components via Inertia
- Pass data to frontend
- Handle web-based interactions
- Return Inertia responses

**Example**: `HomeController.php`
```php
return Inertia::render('Home', [
    'products' => $products,
    'banners' => $banners,
]);
```

#### 2. API Controllers
**Location**: `app/Http/Controllers/Api/`

**Responsibilities**:
- Handle REST API requests
- Return JSON responses
- Use API Resources for formatting
- Apply API middleware

**Example**: `ProductDetailsController.php`
```php
return ApiResponse::sendResponse(200, '', [
    'product' => new ProductDetailsResource($product)
]);
```

### Business Logic Layer

#### Services
Encapsulate complex business operations:
- Order processing (`CheckoutServices`)
- User management (`UserService`)
- SMS verification (`VerificationServices`)
- Cart operations (`CartServices`)

#### Repositories (Partial)
Abstract data access for specific modules:
- Cart operations
- Admin management
- Category handling

### Data Access Layer

#### Eloquent Models
**Location**: `app/Models/`

**Responsibilities**:
- Database entity representation
- Relationship definitions
- Attribute casting
- Query scopes
- Business-specific accessors/mutators

**Example Relationships** (`Product.php`):
```php
public function orders() { return $this->belongsToMany(Order::class, 'order_items'); }
public function colors() { return $this->belongsToMany(Color::class); }
public function images() { return $this->hasMany(ProductImage::class); }
public function company() { return $this->belongsTo(Company::class); }
```

## Request Flow

### Web Request Flow (Inertia.js)

```
User Browser
    ↓
[Web Routes] (routes/web.php)
    ↓
[Middleware Stack]
    - EncryptCookies
    - VerifyCsrfToken
    - ChangeLanguage
    - auth:web (if required)
    ↓
[Inertia Controller] (app/Http/Controllers/Inertia/)
    ↓
[Service Layer] (if complex logic)
    ↓
[Eloquent Models]
    ↓
[Database]
    ↓
[Inertia Response]
    ↓
Vue 3 Component Rendering
```

### API Request Flow

```
Mobile/External Client
    ↓
[API Routes] (routes/api.php)
    ↓
[Middleware Stack]
    - changeLanguage
    - auth:user (Sanctum, if required)
    - guest.header (for guest operations)
    ↓
[API Controller] (app/Http/Controllers/Api/)
    ↓
[Form Request Validation]
    ↓
[Service Layer]
    ↓
[Repository (if exists) / Direct Model]
    ↓
[Database]
    ↓
[API Resource Transformation]
    ↓
[ApiResponse Helper]
    ↓
JSON Response
```

### Admin Dashboard Flow

```
Admin Browser
    ↓
[Dashboard Routes] (routes/dashboard.php)
    ↓
[Middleware: admin]
    ↓
[Dashboard Controller] (app/Http/Controllers/Dashboard/)
    ↓
[Direct Model Access (mostly) / Repository (some)]
    ↓
[Database]
    ↓
[Blade View Response] (INFERRED)
```

## Important Architectural Decisions

### 1. Dual Frontend Strategy

**Decision**: Maintain both Inertia.js (web) and REST API (mobile) interfaces

**Rationale** (INFERRED):
- Serve web customers with modern SPA experience
- Enable mobile app development
- Support third-party integrations

**Implementation**:
- Separate controller namespaces (`Inertia/` vs `Api/`)
- Shared models and services
- Different authentication approaches

### 2. Cookie-Based Guest Shopping

**Decision**: Use UUID-based cookies to track guest carts and orders

**Files**:
- `app/Models/Cart.php` - `getCookieId()` method
- `app/Models/Guest.php` - Guest entity

**Implementation**:
```php
public static function getCookieId()
{
    $cookie_id = Cookie::get('cart_id');
    if (!$cookie_id) {
        $cookie_id = Str::uuid();
        Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
    }
    return $cookie_id;
}
```

**Benefits**:
- Allows shopping without registration
- Persistent cart across sessions
- Mergeable with authenticated user cart

### 3. Multi-Language at Database Level

**Decision**: Store bilingual content in database columns (`name` / `name_en`, `description` / `description_en`)

**Evidence**: Migrations show dual-language fields
- `main_categories`: `name`, `name_en`
- `products`: `name`, `name_en`
- `colors`: `name`, but single `color_code`

**Advantages**:
- No additional translation tables
- Direct query filtering by language
- Simpler data model

**Disadvantages**:
- Schema changes required for new languages
- Larger table sizes

### 4. Mixed Repository Adoption

**Decision**: Implement repositories selectively, not application-wide

**Observed Pattern**:
- Cart module: Full repository
- Admin module: Repository
- Product module: Direct model access
- Order module: Direct model access

**INFERRED Reason**: Incremental refactoring or selective application based on complexity

### 5. Global Scope for Cart Isolation

**Decision**: Use Eloquent global scopes to automatically filter cart queries by cookie

**Implementation**: `Cart.php` model

**Benefit**: Prevents accidental cross-user cart access

**Risk**: Developers must remember to use `withoutGlobalScope('cookie_id')` for admin operations

## Technology Choices

### Why Inertia.js?

**Advantages Leveraged**:
- Server-side routing with client-side rendering
- No API layer needed for web interface
- Laravel ecosystem integration
- SEO-friendly compared to traditional SPAs

### Why Sanctum?

**Advantages**:
- Simple token authentication
- First-party Laravel support
- Cookie-based authentication for SPA
- Token-based for mobile API

### Why Vuetify?

**Advantages** (INFERRED):
- Material Design components
- Arabic RTL support
- Rich component library
- Responsive grid system

## Scalability Considerations

### Current Architecture Scalability

**Strengths**:
- Stateless API design
- Service layer for complex logic
- Proper use of Eloquent relationships

**Potential Bottlenecks**:
1. Direct database queries in controllers (N+1 potential)
2. No caching strategy visible
3. Synchronous queue processing (default)
4. File-based sessions (default)

**Recommendations** (for scale):
- Implement Redis for caching
- Move to queue-based job processing
- Database session driver or Redis sessions
- CDN for static assets

## Security Architecture

### Authentication Boundaries

1. **Public**: No authentication (product browsing, guest checkout)
2. **User-Authenticated**: Sanctum tokens (API) or session (web)
3. **Admin-Authenticated**: Session-based with separate admin guard

### Authorization

**Middleware-Based**:
- `auth:user` - Requires authenticated user
- `auth:web` - Requires web session user
- `admin` - Requires admin authentication
- `guest.header` - Custom guest validation

**Policy-Based**: Not extensively observed in the codebase

### CSRF Protection

**Web Routes**: CSRF tokens via `VerifyCsrfToken` middleware
**API Routes**: Excluded from CSRF (stateless)

## Dependency Management

### Backend Dependencies (composer.json)

**Core**:
- `laravel/framework`: ^10.0
- `laravel/sanctum`: ^3.2
- `inertiajs/inertia-laravel`: ^2.0

**Utilities**:
- `guzzlehttp/guzzle`: ^7.2 - HTTP client
- `stichoza/google-translate-php`: 5.1 - Translation
- `tightenco/ziggy`: ^2.6 - Route generation for JS

**Development**:
- `laravel/telescope`: ^5.19 - Debugging
- `laravel/pint`: ^1.0 - Code styling

### Frontend Dependencies (package.json)

**Core**:
- `vue`: ^3.5.22
- `@inertiajs/vue3`: ^2.2.0
- `vuetify`: ^3.10.3

**Build**:
- `vite`: ^7.1.7
- `laravel-vite-plugin`: ^2.0.1

## Deployment Architecture (INFERRED)

**Likely Setup**:
```
┌─────────────────┐
│  Load Balancer  │
│    (Optional)   │
└────────┬────────┘
         │
┌────────┴────────┐
│   Web Server    │
│  (Nginx/Apache) │
└────────┬────────┘
         │
┌────────┴────────┐
│  Laravel App    │
│   (PHP-FPM)     │
└────────┬────────┘
         │
┌────────┴────────┐
│  MySQL Database │
└─────────────────┘
```

**Evidence**: Standard Laravel deployment pattern, no containerization files detected
