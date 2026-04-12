# Multi-Vendor System - Deployment Checklist

## Pre-Deployment Checklist

### 1. Code Review ✅
- [x] All migrations created (6 files)
- [x] All models created (3 new models)
- [x] All services created (2 services)
- [x] All controllers created (5 new controllers)
- [x] All routes added (vendor, admin, public)
- [x] Observers registered
- [x] Documentation complete

### 2. Database Preparation
- [ ] Backup current database
- [ ] Review migration files
- [ ] Check for conflicts with existing schema
- [ ] Verify foreign key constraints

### 3. Environment Check
- [ ] PHP >= 8.1
- [ ] Laravel >= 10.x
- [ ] MySQL/PostgreSQL configured
- [ ] Storage permissions set (for image uploads)
- [ ] Queue worker running (optional, for notifications)

---

## Deployment Steps

### Step 1: Backup Everything
```bash
# Backup database
php artisan db:backup  # or your backup method

# Backup files
tar -czf backup-$(date +%Y%m%d).tar.gz .
```

### Step 2: Pull Code
```bash
git pull origin main
# or upload files via FTP/SFTP
```

### Step 3: Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### Step 4: Run Migrations
```bash
php artisan migrate
```

**Expected Output:**
```
Migrating: 2026_04_12_000001_add_multi_vendor_support_to_orders
Migrated:  2026_04_12_000001_add_multi_vendor_support_to_orders (XX.XXms)

Migrating: 2026_04_12_000002_add_vendor_branding_fields_to_companies
Migrated:  2026_04_12_000002_add_vendor_branding_fields_to_companies (XX.XXms)

Migrating: 2026_04_12_000003_create_vendor_payouts_table
Migrated:  2026_04_12_000003_create_vendor_payouts_table (XX.XXms)

Migrating: 2026_04_12_000004_create_vendor_earnings_table
Migrated:  2026_04_12_000004_create_vendor_earnings_table (XX.XXms)

Migrating: 2026_04_12_000005_create_vendor_reviews_table
Migrated:  2026_04_12_000005_create_vendor_reviews_table (XX.XXms)

Migrating: 2026_04_12_000006_add_indexes_for_performance
Migrated:  2026_04_12_000006_add_indexes_for_performance (XX.XXms)
```

### Step 5: Setup Multi-Vendor System
```bash
php artisan multivendor:setup
```

**Expected Output:**
```
🚀 Setting up Multi-Vendor System...

Step 1: Updating existing vendors...
  ✓ Updated vendor: Vendor Name 1
  ✓ Updated vendor: Vendor Name 2
  ✅ Updated 2 vendors

Step 2: Creating earnings for existing orders...
  ✓ Created earnings for order #2026000001
  ✓ Created earnings for order #2026000002
  ✅ Created earnings for 2 orders

Step 3: Updating vendor statistics...
  ✅ Updated stats for 2 vendors

✅ Multi-Vendor System Setup Complete!
```

### Step 6: Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Step 7: Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Post-Deployment Testing

### 1. Database Verification
```bash
php artisan tinker
```

```php
// Check vendors have store slugs
Company::where('is_vendor', true)->whereNull('store_slug')->count();
// Should return: 0

// Check earnings exist
\App\Models\VendorEarning::count();
// Should return: > 0 if you have paid orders

// Check payouts table exists
\App\Models\VendorPayout::count();
// Should return: 0 (no payouts generated yet)
```

### 2. Route Testing
```bash
php artisan route:list | grep vendor
php artisan route:list | grep store
php artisan route:list | grep payout
```

**Expected Routes:**
- `GET /vendor/login`
- `GET /vendor/payouts`
- `GET /store/{slug}`
- `GET /admin/vendors`
- `GET /admin/payouts`

### 3. Functional Testing

#### Test 1: Vendor Login
- [ ] Visit `/vendor/login`
- [ ] Login with existing vendor credentials
- [ ] Should redirect to `/vendor/` dashboard
- [ ] Dashboard should show stats

#### Test 2: Vendor Profile
- [ ] Visit `/vendor/profile/edit`
- [ ] Update store slug
- [ ] Upload logo and cover image
- [ ] Save changes
- [ ] Verify images uploaded to `storage/app/public/companies/`

#### Test 3: Public Storefront
- [ ] Get vendor store slug: `Company::first()->store_slug`
- [ ] Visit `/store/{slug}`
- [ ] Should display vendor profile
- [ ] Should list vendor products
- [ ] Should show vendor rating

#### Test 4: Multi-Vendor Checkout
- [ ] Add products from 2 different vendors to cart
- [ ] Complete checkout
- [ ] Check database:
  ```php
  $order = Order::latest()->first();
  $order->is_parent; // Should be true
  $order->subOrders; // Should have 2 sub-orders
  ```

#### Test 5: Earnings Creation
- [ ] Mark an order as paid
- [ ] Check earnings created:
  ```php
  $order = Order::find(123);
  $order->earnings; // Should have earnings records
  ```

#### Test 6: Admin Vendor Management
- [ ] Visit `/admin/vendors`
- [ ] Should list all vendors
- [ ] Click on a vendor
- [ ] Should show vendor details and stats
- [ ] Update commission rate
- [ ] Verify saved

#### Test 7: Payout Generation
- [ ] Visit `/admin/payouts`
- [ ] Click "Generate Payouts"
- [ ] Set date range (e.g., last month)
- [ ] Generate for all vendors
- [ ] Should create payout records
- [ ] Verify in database:
  ```php
  VendorPayout::where('status', 'pending')->count();
  ```

#### Test 8: Mark Payout as Paid
- [ ] Select a pending payout
- [ ] Click "Mark as Paid"
- [ ] Enter transaction reference
- [ ] Save
- [ ] Verify status changed to "paid"
- [ ] Verify earnings status changed to "paid"

#### Test 9: Vendor Reports
- [ ] Login as vendor
- [ ] Visit `/vendor/reports`
- [ ] Should show revenue stats
- [ ] Should show top products
- [ ] Should show sales chart
- [ ] Click "Export CSV"
- [ ] Should download CSV file

---

## Rollback Plan (If Needed)

### If migrations fail:
```bash
# Rollback last batch
php artisan migrate:rollback

# Restore database backup
mysql -u username -p database_name < backup.sql
```

### If system breaks:
```bash
# Restore code backup
tar -xzf backup-YYYYMMDD.tar.gz

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Monitoring & Maintenance

### Daily Tasks:
- [ ] Check error logs: `storage/logs/laravel.log`
- [ ] Monitor vendor registrations
- [ ] Review pending payouts

### Weekly Tasks:
- [ ] Update vendor statistics:
  ```bash
  php artisan tinker
  >>> Company::where('is_vendor', true)->each->updateStats();
  ```
- [ ] Review vendor performance
- [ ] Process pending payouts

### Monthly Tasks:
- [ ] Generate monthly payouts
- [ ] Review commission rates
- [ ] Analyze vendor reports
- [ ] Backup database

---

## Performance Monitoring

### Key Metrics to Track:
1. **Order Processing Time**
   - Multi-vendor orders should process in < 2 seconds

2. **Database Query Count**
   - Use Laravel Debugbar or Telescope
   - Watch for N+1 queries

3. **Storage Usage**
   - Monitor `storage/app/public/companies/` size
   - Implement image optimization if needed

4. **Payout Processing**
   - Track time to generate payouts
   - Monitor payout accuracy

### Optimization Tips:
```php
// Use eager loading
Order::with(['company', 'earnings', 'orderItems.product'])->get();

// Cache vendor stats
Cache::remember("vendor.{$id}.stats", 3600, function() use ($vendor) {
    return [
        'total_revenue' => $vendor->earnings()->sum('vendor_amount'),
        'total_orders' => $vendor->earnings()->distinct('order_id')->count(),
    ];
});
```

---

## Security Checklist

### Access Control:
- [ ] Vendors can only access their own data
- [ ] Admins can access all vendor data
- [ ] Customers can only view active vendors
- [ ] Payout generation restricted to admins

### Data Validation:
- [ ] Commission rates validated (0-100%)
- [ ] Store slugs are unique
- [ ] Image uploads validated (type, size)
- [ ] Financial calculations use Decimal type

### Audit Trail:
- [ ] Payouts track `processed_by` admin
- [ ] Payouts have `transaction_reference`
- [ ] Earnings linked to specific orders
- [ ] All status changes logged

---

## Common Issues & Solutions

### Issue 1: Migration fails on `store_slug` unique constraint
**Cause:** Duplicate vendor names  
**Solution:**
```bash
php artisan tinker
>>> Company::where('is_vendor', true)->each(function($v, $i) {
    $v->store_slug = Str::slug($v->name) . '-' . $i;
    $v->save();
});
```

### Issue 2: Earnings not created automatically
**Cause:** Observer not registered  
**Solution:** Check `AppServiceProvider::boot()` has:
```php
\App\Models\Order::observe(\App\Observers\OrderObserver::class);
```

### Issue 3: Vendor storefront 404
**Cause:** Route cache  
**Solution:**
```bash
php artisan route:clear
php artisan route:cache
```

### Issue 4: Images not displaying
**Cause:** Storage link missing  
**Solution:**
```bash
php artisan storage:link
```

---

## Success Criteria

✅ **System is ready when:**
- [ ] All migrations run successfully
- [ ] All vendors have store slugs
- [ ] Earnings created for existing orders
- [ ] Vendor login works
- [ ] Admin vendor management works
- [ ] Public storefront displays
- [ ] Multi-vendor checkout creates sub-orders
- [ ] Payout generation works
- [ ] Reports display correctly
- [ ] No errors in logs

---

## Support Contacts

**Technical Issues:**
- Check documentation: `MULTI_VENDOR_SYSTEM.md`
- Review implementation: `IMPLEMENTATION_SUMMARY.md`
- Quick start: `QUICK_START.md`

**Database Issues:**
- Review migrations in `database/migrations/`
- Check model relationships in `app/Models/`

**Business Logic:**
- Review services in `app/Services/`
- Check observers in `app/Observers/`

---

## Final Verification

Run this command to verify everything:
```bash
php artisan tinker
```

```php
// 1. Check vendors
$vendors = Company::where('is_vendor', true)->count();
echo "Vendors: {$vendors}\n";

// 2. Check store slugs
$withSlugs = Company::where('is_vendor', true)->whereNotNull('store_slug')->count();
echo "With slugs: {$withSlugs}\n";

// 3. Check earnings
$earnings = \App\Models\VendorEarning::count();
echo "Earnings: {$earnings}\n";

// 4. Check payouts
$payouts = \App\Models\VendorPayout::count();
echo "Payouts: {$payouts}\n";

// 5. Test route
echo "Test storefront: /store/" . Company::where('is_vendor', true)->first()->store_slug . "\n";
```

**Expected Output:**
```
Vendors: X
With slugs: X (should match vendors)
Earnings: X (should be > 0 if you have paid orders)
Payouts: X (0 is OK if not generated yet)
Test storefront: /store/vendor-name
```

---

## 🎉 Deployment Complete!

If all checks pass, your multi-vendor system is live and ready for production use.

**Next Steps:**
1. Notify vendors of new features
2. Train admin staff on payout process
3. Monitor system for first week
4. Collect feedback from vendors
5. Plan future enhancements

**Congratulations! 🚀**
