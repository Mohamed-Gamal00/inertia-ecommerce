# Installation and Development Guide

## Prerequisites

### Required Software

- **PHP**: 8.1 or higher
- **Composer**: 2.x or higher
- **Node.js**: 14.x or higher
- **npm**: 6.x or higher (or Yarn)
- **MySQL**: 5.7+ or 8.0+
- **Web Server**: Apache or Nginx (for local development, PHP's built-in server can be used)

### Recommended PHP Extensions

```bash
php -m | grep -E 'pdo|mysql|mbstring|tokenizer|xml|ctype|json|bcmath|fileinfo|openssl'
```

Required extensions:
- `pdo_mysql` - Database connectivity
- `mbstring` - Multibyte string support
- `tokenizer` - Laravel framework
- `xml` - XML processing
- `ctype` - Character type checking
- `json` - JSON processing
- `bcmath` - Precision mathematics
- `fileinfo` - File information
- `openssl` - Encryption

### Recommended System Tools

- **Git**: Version control
- **Redis**: (Optional) For caching and queues
- **Supervisor**: (Optional) For queue workers

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url> ecommerce-platform
cd ecommerce-platform
```

### 2. Install Backend Dependencies

```bash
composer install
```

**Development vs Production**:
```bash
# Development (includes dev dependencies)
composer install

# Production (excludes dev dependencies)
composer install --no-dev --optimize-autoloader
```

### 3. Install Frontend Dependencies

```bash
npm install
```

**Alternative with Yarn**:
```bash
yarn install
```

### 4. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

**Edit `.env` file** with your configuration:

```env
# Application
APP_NAME="Your Store Name"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailpit  # or your SMTP server
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Payment Gateway (Moyasar)
MOYASAR_PUBLISHABLE_KEY=pk_test_your_publishable_key
MOYASAR_SECRET_KEY=sk_test_your_secret_key

# SMS Gateway
SMS_API_KEY=your_sms_api_key
SMS_USER_NAME=your_sms_username
SMS_SENDER=YourCompany

# Queue Configuration
QUEUE_CONNECTION=sync  # Use 'redis' or 'database' for production

# Session & Cache
SESSION_DRIVER=file  # Use 'redis' for production
CACHE_DRIVER=file    # Use 'redis' for production
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

This sets the `APP_KEY` in your `.env` file.

### 6. Create Database

Create a MySQL database for the application:

```bash
mysql -u root -p
```

```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

**Fresh Installation** (drops all tables and re-creates):
```bash
php artisan migrate:fresh
```

**With Seeding** (if seeders are available):
```bash
php artisan migrate --seed
```

or

```bash
php artisan migrate:fresh --seed
```

### 8. Create Storage Link

Link the public storage directory:

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`.

### 9. Set Directory Permissions

**Linux/macOS**:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Development** (less restrictive):
```bash
chmod -R 777 storage bootstrap/cache
```

### 10. Build Frontend Assets

**Development** (with hot reload):
```bash
npm run dev
```

**Production Build**:
```bash
npm run build
```

### 11. Configure Payment Gateway (Moyasar)

Add Moyasar credentials to `.env`:

```env
MOYASAR_PUBLISHABLE_KEY=your_publishable_key
MOYASAR_SECRET_KEY=your_secret_key
```

**Note**: These credentials will be automatically populated in the settings table when running seeders (step 13).

### 12. Configure SMS Gateway

Add SMS service credentials to `.env`:

```env
SMS_API_KEY=your_sms_api_key
SMS_USER_NAME=your_sms_username
SMS_SENDER=YourCompany
```

**Note**: These credentials will be automatically populated in the settings table when running seeders (step 13).

### 13. Seed Initial Data (REQUIRED)

Run the database seeders to populate initial data including settings, admin user, and configurations:

```bash
php artisan db:seed
```

Or during migration:

```bash
php artisan migrate:fresh --seed
```

**What gets seeded**:
- Application settings (including Moyasar and SMS credentials from .env)
- Default order statuses
- Shipping configuration
- Admin user (if AdminSeeder exists)

**Manual Admin Creation** (if seeder doesn't exist):

```bash
php artisan tinker
```

```php
// Create admin user
\App\Models\Admin::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'super_admin' => true
]);

// Create default order status
\App\Models\OrderStatus::create([
    'name' => 'قيد الانتظار',
    'name_en' => 'Pending',
    'default_status' => true,
    'arrangement' => 1
]);

// Create shipping configuration
\App\Models\ShippingTypesAndPrice::create([
    'add_pickup_from_store' => true,
    'add_normal_price' => true,
    'normal_shipping_price' => 20.00
]);
```

**Note**: The SettingsSeeder automatically pulls Moyasar and SMS credentials from your `.env` file.

## Running the Application

### Development Server

#### Using PHP Built-in Server

```bash
php artisan serve
```

Application will be available at: `http://localhost:8000`

**Custom Host and Port**:
```bash
php artisan serve --host=0.0.0.0 --port=8080
```

#### Using Laravel Sail (Docker)

If using Laravel Sail:

```bash
./vendor/bin/sail up
```

### Frontend Development

**Hot Module Replacement** (recommended for development):

```bash
npm run dev
```

This starts Vite dev server with HMR for instant updates.

### Queue Worker (if using queues)

For production or testing queue functionality:

```bash
php artisan queue:work
```

**Development** (auto-restart on code changes):
```bash
php artisan queue:work --tries=3
```

### Task Scheduler

For scheduled tasks, add to crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Access Points

### Web Application (Inertia.js)
- **URL**: `http://localhost:8000`
- **Home**: `/`
- **Login**: `/login`
- **Register**: `/register`
- **Products**: `/products`
- **Cart**: `/cart`
- **Checkout**: `/checkout`

### Admin Dashboard
- **URL**: `http://localhost:8000/admin/login`
- **Default Credentials**: Create admin user using tinker (see step 13)

### API
- **Base URL**: `http://localhost:8000/api`
- **Example**: `http://localhost:8000/api/products/1`

## Development Workflow

### 1. Start Development Environment

**Terminal 1** - Backend:
```bash
php artisan serve
```

**Terminal 2** - Frontend (HMR):
```bash
npm run dev
```

**Terminal 3** - Queue Worker (optional):
```bash
php artisan queue:work
```

### 2. Make Code Changes

- **Backend**: Edit files in `app/`, routes, migrations
- **Frontend**: Edit Vue components (typically in `resources/js/`)
- **Styles**: Edit CSS/SCSS files

### 3. Database Changes

**Create Migration**:
```bash
php artisan make:migration create_example_table
```

**Run Migration**:
```bash
php artisan migrate
```

**Rollback Last Migration**:
```bash
php artisan migrate:rollback
```

**Reset Database**:
```bash
php artisan migrate:fresh --seed
```

### 4. Create New Features

**Create Model**:
```bash
php artisan make:model Example -m  # -m creates migration
php artisan make:model Example -mfc  # -mfc creates migration, factory, controller
```

**Create Controller**:
```bash
php artisan make:controller ExampleController
php artisan make:controller Api/ExampleController --api  # API resource controller
```

**Create Form Request**:
```bash
php artisan make:request ExampleRequest
```

**Create Resource**:
```bash
php artisan make:resource ExampleResource
```

**Create Service**:
```bash
mkdir -p app/Services
# Manually create service class
```

### 5. Testing

**Run Tests**:
```bash
php artisan test
```

**Run Specific Test**:
```bash
php artisan test --filter=ExampleTest
```

**With Coverage**:
```bash
php artisan test --coverage
```

## Common Development Tasks

### Clear Application Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**Clear Everything**:
```bash
php artisan optimize:clear
```

### Regenerate Cached Files

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Optimize for Production**:
```bash
php artisan optimize
```

### Database Maintenance

**Refresh Database** (drop all tables and re-migrate):
```bash
php artisan migrate:fresh
```

**Seed Database**:
```bash
php artisan db:seed
```

**Reset and Seed**:
```bash
php artisan migrate:fresh --seed
```

### Storage Management

**Create Storage Link** (if not already created):
```bash
php artisan storage:link
```

**Clear Storage** (CAUTION: This deletes uploaded files):
```bash
rm -rf storage/app/public/*
```

### Debugging

**Enable Debug Bar** (if installed):
```env
APP_DEBUG=true
```

**Use Telescope**:
```bash
php artisan telescope:install
php artisan migrate
```

Access Telescope at: `http://localhost:8000/telescope`

**Tinker Console**:
```bash
php artisan tinker
```

Example queries in Tinker:
```php
\App\Models\User::count();
\App\Models\Product::with('images')->first();
\App\Models\Order::where('payment_status', 'paid')->get();
```

## Troubleshooting

### Issue: "No application encryption key has been specified"

**Solution**:
```bash
php artisan key:generate
```

### Issue: "SQLSTATE[HY000] [1045] Access denied"

**Solution**:
- Check database credentials in `.env`
- Verify MySQL is running: `mysql -u root -p`
- Grant permissions to database user

### Issue: "The stream or file could not be opened"

**Solution**:
```bash
chmod -R 777 storage bootstrap/cache
```

### Issue: "Vite manifest not found"

**Solution**:
```bash
npm run build
```

or run dev server:
```bash
npm run dev
```

### Issue: "Class not found"

**Solution**:
```bash
composer dump-autoload
```

### Issue: "Route [login] not defined"

**Solution**:
```bash
php artisan route:cache
php artisan route:clear
```

### Issue: "Mixed Content" warnings with Vite HMR

**Solution**:
Update `vite.config.js` to use HTTPS or ensure `APP_URL` matches your development environment.

## Environment-Specific Configuration

### Local Development

`.env` settings:
```env
APP_ENV=local
APP_DEBUG=true
QUEUE_CONNECTION=sync
CACHE_DRIVER=file
SESSION_DRIVER=file
```

### Staging

```env
APP_ENV=staging
APP_DEBUG=false
QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

### Production

```env
APP_ENV=production
APP_DEBUG=false
QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
LOG_CHANNEL=daily
```

## Security Checklist for Development

- [ ] Never commit `.env` file
- [ ] Use strong database passwords
- [ ] Keep `APP_DEBUG=false` in production
- [ ] Use HTTPS in production
- [ ] Set proper file permissions
- [ ] Use environment variables for secrets
- [ ] Keep dependencies updated
- [ ] Disable Telescope in production
- [ ] Enable CSRF protection
- [ ] Use prepared statements (Eloquent does this)

## Recommended Development Tools

### IDE/Editor
- **PhpStorm** - Full Laravel support
- **VS Code** - With extensions:
  - Laravel Extension Pack
  - Intelephense (PHP)
  - Volar (Vue 3)
  - ESLint
  - Prettier

### Browser Extensions
- **Vue DevTools** - Vue component debugging
- **React DevTools** - If using React (not applicable here)

### Database Tools
- **TablePlus** - Database GUI
- **MySQL Workbench** - MySQL management
- **phpMyAdmin** - Web-based MySQL admin

### API Testing
- **Postman** - API testing
- **Insomnia** - API client
- **HTTPie** - Command-line HTTP client

### Version Control
- **GitKraken** - Git GUI
- **SourceTree** - Git client
- **Git CLI** - Command-line git

## Useful Artisan Commands

### Information
```bash
php artisan about              # Application information
php artisan route:list         # List all routes
php artisan migrate:status     # Migration status
```

### Code Generation
```bash
php artisan make:model Product -mfc    # Model with migration, factory, controller
php artisan make:controller Api/ProductController --api
php artisan make:request StoreProductRequest
php artisan make:resource ProductResource
php artisan make:middleware CheckAge
```

### Database
```bash
php artisan migrate                # Run migrations
php artisan migrate:rollback       # Rollback last batch
php artisan migrate:fresh          # Drop all tables and re-migrate
php artisan db:seed                # Run seeders
php artisan make:migration name    # Create migration
php artisan make:seeder NameSeeder # Create seeder
```

### Cache & Optimization
```bash
php artisan cache:clear        # Clear application cache
php artisan config:cache       # Cache configuration
php artisan route:cache        # Cache routes
php artisan view:cache         # Compile views
php artisan optimize           # Optimize for production
php artisan optimize:clear     # Clear all optimization caches
```

### Queue & Schedule
```bash
php artisan queue:work         # Start queue worker
php artisan queue:restart      # Restart queue workers
php artisan schedule:run       # Run scheduled tasks
php artisan schedule:work      # Run scheduler in foreground
```

## Next Steps

After successful installation:

1. **Configure Admin Settings**: Login to admin dashboard and configure:
   - Website settings
   - Payment gateway credentials
   - SMS service credentials
   - Shipping options
   - VAT settings

2. **Create Initial Data**:
   - Categories
   - Products
   - Order statuses
   - Discount codes

3. **Test Core Flows**:
   - User registration and login
   - Product browsing
   - Cart operations
   - Checkout process
   - Payment integration (sandbox mode)
   - Admin order management

4. **Frontend Customization**:
   - Update branding
   - Customize Vue components
   - Adjust styling (Vuetify theme)

5. **Review Security**:
   - Fix hard-coded OTP code in `VerificationServices.php`
   - Implement rate limiting
   - Add authorization policies
   - Review CORS settings

## Support Resources

- **Laravel Documentation**: https://laravel.com/docs/10.x
- **Vue 3 Documentation**: https://vuejs.org
- **Inertia.js Documentation**: https://inertiajs.com
- **Vuetify Documentation**: https://vuetifyjs.com
- **Laravel Sanctum**: https://laravel.com/docs/10.x/sanctum

## Additional Notes

### Critical Security Fix Required

Before deployment, fix the hard-coded OTP verification code:

**File**: `app/Services/VerificationServices.php`

**Current (INSECURE)**:
```php
'code' => 1111,
```

**Should be**:
```php
'code' => $code,
```

### Performance Recommendations

For production:
1. Enable Redis for caching and sessions
2. Set up queue workers with Supervisor
3. Enable OPcache for PHP
4. Use CDN for static assets
5. Implement database read replicas (if high traffic)

### Backup Strategy

Implement regular backups:
```bash
# Database backup
mysqldump -u username -p database_name > backup.sql

# Storage backup
tar -czf storage_backup.tar.gz storage/app/public
```
