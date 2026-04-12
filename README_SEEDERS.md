# Multi-Vendor System Seeders

## Overview
This document describes the seeders created for the multi-vendor e-commerce system.

## Available Seeders

### 1. VendorSeeder
Creates sample vendor accounts with complete profiles.

**Creates:**
- 5 vendor accounts with different statuses
- Complete vendor profiles (branding, policies, bank details)
- Social media links
- Store slugs

**Sample Vendors:**
1. **Modern Electronics Store** (Active)
   - Email: `electronics@vendor.com`
   - Password: `password`
   - Store: `/store/modern-electronics`
   - Commission: 10%

2. **Fashion Trends Store** (Active)
   - Email: `fashion@vendor.com`
   - Password: `password`
   - Store: `/store/fashion-trends`
   - Commission: 12%

3. **Home Furniture Store** (Active)
   - Email: `furniture@vendor.com`
   - Password: `password`
   - Store: `/store/home-furniture`
   - Commission: 8%

4. **Sports & Fitness Store** (Pending - for testing approval)
   - Email: `sports@vendor.com`
   - Password: `password`
   - Store: `/store/sports-fitness`
   - Commission: 15%

5. **Books & Stationery Store** (Active)
   - Email: `books@vendor.com`
   - Password: `password`
   - Store: `/store/books-stationery`
   - Commission: 10%

### 2. VendorEarningSeeder
Creates earnings records for existing paid orders.

**What it does:**
- Finds all paid orders with vendors
- Calculates commission based on vendor's commission rate
- Creates earnings records with status "available"
- Links earnings to orders and order items

**Requirements:**
- Existing orders with `payment_status = 'paid'`
- Orders must have `company_id` set

### 3. VendorReviewSeeder
Creates sample customer reviews for vendors.

**Creates:**
- 3-5 reviews per vendor
- Mix of ratings (2-5 stars)
- Arabic review comments
- Mix of approved and pending reviews
- Updates vendor ratings automatically

**Sample Reviews:**
- "خدمة ممتازة ومنتجات عالية الجودة" (5 stars)
- "تجربة جيدة بشكل عام. التوصيل كان سريع" (4 stars)
- "المنتج لم يكن كما توقعت" (2 stars, pending)

### 4. VendorPayoutSeeder
Generates sample payouts for vendors.

**What it does:**
- Generates payouts for last month
- Groups available earnings into payouts
- Randomly marks some as paid (for demo)
- Creates transaction references

**Requirements:**
- Active vendors
- Available earnings for the period

### 5. MultiVendorSeeder (Main Seeder)
Runs all vendor seeders in the correct order.

**Order of execution:**
1. VendorSeeder - Create vendors
2. VendorEarningSeeder - Create earnings
3. VendorReviewSeeder - Create reviews
4. VendorPayoutSeeder - Generate payouts

## Usage

### Run All Multi-Vendor Seeders
```bash
php artisan db:seed --class=MultiVendorSeeder
```

**Output:**
```
🚀 Seeding Multi-Vendor System...

Step 1: Creating vendors...
✅ Created 5 vendors

Step 2: Creating vendor earnings...
✅ Created earnings for X orders

Step 3: Creating vendor reviews...
✅ Created X vendor reviews

Step 4: Generating vendor payouts...
✅ Created X payouts for period: 2026-03-01 to 2026-03-31

✅ Multi-Vendor System Seeding Complete!
```

### Run Individual Seeders

**Create only vendors:**
```bash
php artisan db:seed --class=VendorSeeder
```

**Create only earnings:**
```bash
php artisan db:seed --class=VendorEarningSeeder
```

**Create only reviews:**
```bash
php artisan db:seed --class=VendorReviewSeeder
```

**Create only payouts:**
```bash
php artisan db:seed --class=VendorPayoutSeeder
```

### Run All Seeders (Including Multi-Vendor)
```bash
php artisan db:seed
```

This will run all seeders including the multi-vendor system.

### Fresh Database with Seeders
```bash
php artisan migrate:fresh --seed
```

**Warning:** This will drop all tables and recreate them!

## Testing the Seeded Data

### 1. Test Vendor Login
```bash
# Visit: /vendor/login
# Email: electronics@vendor.com
# Password: password
```

### 2. Test Vendor Storefront
```bash
# Visit: /store/modern-electronics
# Should display vendor profile and products
```

### 3. Test Admin Vendor Management
```bash
# Visit: /admin/vendors
# Should list all 5 vendors
```

### 4. Test Payouts
```bash
# Visit: /admin/payouts
# Should show generated payouts
```

### 5. Verify in Database
```bash
php artisan tinker
```

```php
// Check vendors
Company::where('is_vendor', true)->count(); // Should be 5

// Check earnings
\App\Models\VendorEarning::count(); // Should be > 0

// Check reviews
\App\Models\VendorReview::count(); // Should be > 0

// Check payouts
\App\Models\VendorPayout::count(); // Should be > 0

// Get vendor with stats
$vendor = Company::where('store_slug', 'modern-electronics')->first();
echo "Rating: {$vendor->rating}\n";
echo "Reviews: {$vendor->approvedReviews()->count()}\n";
```

## Customization

### Change Vendor Data
Edit `database/seeders/VendorSeeder.php` and modify the `$vendors` array.

### Change Commission Rates
```php
// In VendorSeeder.php
'commission_rate' => 15.00, // Change to your rate
```

### Change Review Comments
Edit `database/seeders/VendorReviewSeeder.php` and modify the `$reviews` array.

### Change Payout Period
Edit `database/seeders/VendorPayoutSeeder.php`:
```php
// Change from last month to custom period
$periodStart = Carbon::parse('2026-01-01');
$periodEnd = Carbon::parse('2026-01-31');
```

## Troubleshooting

### Issue: "No paid orders found"
**Solution:** Create some orders first or mark existing orders as paid:
```php
Order::whereNotNull('company_id')->update(['payment_status' => 'paid']);
```

### Issue: "No active vendors found"
**Solution:** Run VendorSeeder first:
```bash
php artisan db:seed --class=VendorSeeder
```

### Issue: "Duplicate entry for vendor email"
**Solution:** Vendors already exist. Either:
1. Delete existing vendors: `Company::where('is_vendor', true)->delete();`
2. Or skip VendorSeeder and run only other seeders

### Issue: "No users found for reviews"
**Solution:** Create some users first:
```php
User::factory(10)->create();
```

## Production Considerations

### DO NOT run in production:
- `php artisan migrate:fresh --seed` (destroys data!)
- `php artisan db:seed` (may create duplicate data)

### Safe for production:
- `php artisan db:seed --class=VendorSeeder` (if you need sample vendors)
- `php artisan db:seed --class=VendorEarningSeeder` (creates earnings for existing orders)

### Recommended for production:
Instead of seeders, use the setup command:
```bash
php artisan multivendor:setup
```

This safely updates existing data without creating duplicates.

## Seeder Dependencies

```
MultiVendorSeeder
├── VendorSeeder (creates vendors)
├── VendorEarningSeeder (requires: orders, vendors)
├── VendorReviewSeeder (requires: vendors, users, orders)
└── VendorPayoutSeeder (requires: vendors, earnings)
```

**Order matters!** Always run VendorSeeder first.

## Data Created

After running `MultiVendorSeeder`, you'll have:

- ✅ 5 vendors (4 active, 1 pending)
- ✅ Earnings for all paid orders
- ✅ 15-25 vendor reviews
- ✅ 1-5 payouts (some marked as paid)
- ✅ Updated vendor ratings
- ✅ Complete vendor profiles with branding

## Next Steps

After seeding:
1. Login as vendor: `/vendor/login`
2. Visit vendor storefront: `/store/modern-electronics`
3. Test multi-vendor checkout
4. Review admin panels: `/admin/vendors` and `/admin/payouts`
5. Test payout generation and approval

## Support

For issues with seeders:
1. Check error messages in terminal
2. Verify database has required data (orders, users)
3. Check `storage/logs/laravel.log`
4. Run seeders individually to isolate issues

---

**Happy Testing! 🎉**
