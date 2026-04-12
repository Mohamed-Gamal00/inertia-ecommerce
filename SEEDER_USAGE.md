# Multi-Vendor Seeders - Usage Guide

## 🚀 Quick Commands

### Run Complete Multi-Vendor Seeding (Recommended)
```bash
php artisan db:seed --class=MultiVendorSeeder
```
This will:
1. Create/update 5 vendors
2. Ask if you want test data (users, products, orders)
3. Create earnings for paid orders
4. Create vendor reviews
5. Generate payouts

### Run Individual Seeders

**Create only vendors:**
```bash
php artisan db:seed --class=VendorSeeder
```

**Create test data (users, products, orders):**
```bash
php artisan db:seed --class=TestDataSeeder
```

**Create earnings:**
```bash
php artisan db:seed --class=VendorEarningSeeder
```

**Create reviews:**
```bash
php artisan db:seed --class=VendorReviewSeeder
```

**Generate payouts:**
```bash
php artisan db:seed --class=VendorPayoutSeeder
```

---

## 📊 What Gets Created

### VendorSeeder
✅ 5 vendors with complete profiles  
✅ Store slugs (unique URLs)  
✅ Branding (colors, social media)  
✅ Policies (return, shipping)  
✅ Bank details  
✅ Commission rates  

**Note:** Uses `updateOrCreate` - safe to run multiple times!

### TestDataSeeder (NEW!)
✅ 3 test users  
✅ Assigns 20 products to vendors  
✅ Creates 5 sample orders  
✅ Mix of paid and pending orders  

### VendorEarningSeeder
✅ Creates earnings for all paid orders  
✅ Calculates commission automatically  
✅ Links earnings to orders  

### VendorReviewSeeder
✅ 3-5 reviews per vendor  
✅ Mix of ratings (2-5 stars)  
✅ Arabic comments  
✅ Updates vendor ratings  

### VendorPayoutSeeder
✅ Generates payouts for last month  
✅ Groups earnings into payouts  
✅ Some marked as paid (demo)  

---

## 🎯 Common Scenarios

### Scenario 1: Fresh Installation
```bash
# Run migrations
php artisan migrate

# Seed everything
php artisan db:seed --class=MultiVendorSeeder
# Answer "yes" when asked about test data
```

### Scenario 2: Already Have Vendors
```bash
# Just update vendors and create test data
php artisan db:seed --class=MultiVendorSeeder
# Answer "yes" for test data
```

### Scenario 3: Already Have Products & Orders
```bash
# Just create vendors
php artisan db:seed --class=VendorSeeder

# Create earnings for existing orders
php artisan db:seed --class=VendorEarningSeeder

# Create reviews (if you have users)
php artisan db:seed --class=VendorReviewSeeder

# Generate payouts
php artisan db:seed --class=VendorPayoutSeeder
```

### Scenario 4: Need Test Data Only
```bash
php artisan db:seed --class=TestDataSeeder
```

---

## ✅ Test Credentials

### Vendors:
| Email | Password | Store URL | Status |
|-------|----------|-----------|--------|
| electronics@vendor.com | password | /store/modern-electronics | Active |
| fashion@vendor.com | password | /store/fashion-trends | Active |
| furniture@vendor.com | password | /store/home-furniture | Active |
| sports@vendor.com | password | /store/sports-fitness | Pending |
| books@vendor.com | password | /store/books-stationery | Active |

### Test Users:
| Email | Password |
|-------|----------|
| ahmed@test.com | password |
| sara@test.com | password |
| khalid@test.com | password |

---

## 🔧 Troubleshooting

### Error: "Duplicate entry for email"
**Solution:** The seeder now uses `updateOrCreate` - this shouldn't happen anymore. But if it does:
```bash
# Delete existing vendors
php artisan tinker
>>> Company::where('is_vendor', true)->delete();
>>> exit

# Run seeder again
php artisan db:seed --class=VendorSeeder
```

### Warning: "No paid orders found"
**Solution:** Create test data first:
```bash
php artisan db:seed --class=TestDataSeeder
```

Or mark existing orders as paid:
```bash
php artisan tinker
>>> Order::whereNotNull('company_id')->update(['payment_status' => 'paid']);
```

### Warning: "No users found"
**Solution:** Create test users:
```bash
php artisan db:seed --class=TestDataSeeder
```

Or use factory:
```bash
php artisan tinker
>>> User::factory(10)->create();
```

### Warning: "No products assigned to vendors"
**Solution:** Run TestDataSeeder to assign products:
```bash
php artisan db:seed --class=TestDataSeeder
```

---

## 🧪 Verification

After seeding, verify everything worked:

```bash
php artisan tinker
```

```php
// Check vendors
Company::where('is_vendor', true)->count(); // Should be 5

// Check store slugs
Company::where('is_vendor', true)->pluck('store_slug');

// Check test users
User::whereIn('email', ['ahmed@test.com', 'sara@test.com'])->count(); // Should be 2-3

// Check products assigned to vendors
Product::whereNotNull('company_id')->count(); // Should be > 0

// Check orders
Order::whereNotNull('company_id')->count(); // Should be > 0

// Check earnings
\App\Models\VendorEarning::count(); // Should be > 0 if you have paid orders

// Check reviews
\App\Models\VendorReview::count(); // Should be > 0 if you have users

// Check payouts
\App\Models\VendorPayout::count(); // Should be > 0 if you have earnings
```

---

## 📝 Notes

### Safe to Run Multiple Times:
- ✅ VendorSeeder (uses updateOrCreate)
- ✅ TestDataSeeder (uses updateOrCreate for users)

### May Create Duplicates:
- ⚠️ VendorEarningSeeder (check for existing earnings first)
- ⚠️ VendorReviewSeeder (may create duplicate reviews)
- ⚠️ VendorPayoutSeeder (may create duplicate payouts)

### Recommended Order:
1. VendorSeeder (always first)
2. TestDataSeeder (if you need test data)
3. VendorEarningSeeder (after you have orders)
4. VendorReviewSeeder (after you have users)
5. VendorPayoutSeeder (after you have earnings)

---

## 🎉 Quick Start

**For a complete test environment:**

```bash
# 1. Run migrations
php artisan migrate

# 2. Seed multi-vendor system
php artisan db:seed --class=MultiVendorSeeder
# Answer "yes" when asked about test data

# 3. Verify
php artisan tinker
>>> Company::where('is_vendor', true)->count(); // 5
>>> User::count(); // 3+
>>> Order::count(); // 5+
>>> \App\Models\VendorEarning::count(); // Should be > 0
```

**Now you can:**
- ✅ Login as vendor: `/vendor/login` (electronics@vendor.com / password)
- ✅ Visit storefront: `/store/modern-electronics`
- ✅ Test admin panel: `/admin/vendors`
- ✅ View payouts: `/admin/payouts`

---

## 💡 Tips

1. **Always run VendorSeeder first** - other seeders depend on it
2. **Use TestDataSeeder** for a complete test environment
3. **Check warnings** - they tell you what's missing
4. **Run seeders individually** to debug issues
5. **Use `updateOrCreate`** in your own seeders to avoid duplicates

---

**Happy Testing! 🚀**
