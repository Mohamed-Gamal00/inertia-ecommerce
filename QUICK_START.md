# Multi-Vendor System - Quick Start Guide

## 🚀 Installation (5 Minutes)

### Step 1: Run Migrations
```bash
php artisan migrate
```

### Step 2: Setup Existing Data
```bash
php artisan multivendor:setup
```

This command will:
- ✅ Generate store slugs for all vendors
- ✅ Set default commission rates (10%)
- ✅ Create earnings for existing paid orders
- ✅ Update vendor statistics

### Step 3: Test the System
```bash
# Check vendor store slugs
php artisan tinker
>>> Company::where('is_vendor', true)->pluck('store_slug', 'name')

# Visit a vendor storefront
# http://your-domain.com/store/{slug}
```

---

## 📋 Key URLs

### For Vendors:
- `/vendor/login` - Vendor login
- `/vendor/register` - Vendor registration
- `/vendor/` - Dashboard
- `/vendor/products` - Manage products
- `/vendor/orders` - View orders
- `/vendor/payouts` - View payouts & earnings
- `/vendor/reports` - Analytics & reports
- `/vendor/profile/edit` - Edit store profile

### For Admins:
- `/admin/vendors` - Manage vendors
- `/admin/vendors/{id}` - Vendor details
- `/admin/payouts` - Manage payouts
- `/admin/payouts/generate` - Generate new payouts

### For Customers:
- `/store/{slug}` - Vendor public storefront

---

## 🎯 Common Tasks

### 1. Approve a New Vendor
```
Admin Panel → Vendors → Select Vendor → Change Status to "Active"
```

### 2. Set Vendor Commission Rate
```
Admin Panel → Vendors → Select Vendor → Update Commission Rate
```

### 3. Generate Monthly Payouts
```
Admin Panel → Payouts → Generate Payouts
- Set period: 2026-01-01 to 2026-01-31
- Leave vendor empty (for all vendors) or select specific vendor
- Click Generate
```

### 4. Mark Payout as Paid
```
Admin Panel → Payouts → Select Payout → Mark as Paid
- Enter transaction reference
- Add notes (optional)
- Click Save
```

### 5. Vendor Updates Store Profile
```
Vendor Panel → Profile → Edit
- Upload logo and cover image
- Set store slug (URL)
- Add social media links
- Configure policies
- Add bank details
- Click Save
```

### 6. Export Vendor Reports
```
Vendor Panel → Reports
- Select date range
- Click "Export to CSV"
```

---

## 🔧 Configuration

### Default Commission Rate
Edit in: `app/Console/Commands/SetupMultiVendorSystem.php`
```php
$updates['commission_rate'] = 10.00; // Change to your rate
```

### Vendor Status Options
- `pending` - Awaiting approval
- `active` - Can sell products
- `suspended` - Temporarily disabled

### Earnings Status Flow
```
pending → available → paid
```

---

## 📊 Database Structure

### Key Tables:
1. **orders** - Customer orders
   - `parent_order_id` - Links to parent order (multi-vendor)
   - `is_parent` - True for parent orders
   - `company_id` - Vendor ID for sub-orders

2. **vendor_earnings** - Individual earnings
   - `item_total` - Order item total
   - `commission_amount` - Platform commission
   - `vendor_amount` - Vendor receives
   - `status` - pending/available/paid

3. **vendor_payouts** - Payout batches
   - `amount` - Total amount
   - `net_amount` - After commission
   - `status` - pending/processing/paid/failed
   - `period_start/end` - Payout period

4. **companies** (vendors)
   - `store_slug` - Unique URL
   - `commission_rate` - Commission %
   - `rating` - Average rating
   - `total_sales` - Cached sales

---

## 🧪 Testing Checklist

### Basic Flow:
1. ✅ Register new vendor → Status is "pending"
2. ✅ Admin approves vendor → Status becomes "active"
3. ✅ Vendor adds products
4. ✅ Customer adds products from 2 vendors to cart
5. ✅ Customer checks out → Creates 1 parent + 2 sub-orders
6. ✅ Payment completed → Earnings created with status "available"
7. ✅ Admin generates payout → Earnings linked to payout
8. ✅ Admin marks payout as paid → Earnings status becomes "paid"

### Vendor Features:
- ✅ Vendor can edit profile
- ✅ Vendor can upload logo and cover
- ✅ Vendor can set store slug
- ✅ Vendor can view earnings
- ✅ Vendor can view payouts
- ✅ Vendor can generate reports
- ✅ Vendor can export CSV

### Admin Features:
- ✅ Admin can list vendors
- ✅ Admin can approve/suspend vendors
- ✅ Admin can set commission rates
- ✅ Admin can generate payouts
- ✅ Admin can mark payouts as paid
- ✅ Admin can view vendor statistics

### Public Features:
- ✅ Customer can visit vendor storefront
- ✅ Customer can view vendor products
- ✅ Customer can read vendor reviews
- ✅ Customer can purchase from multiple vendors

---

## 🐛 Troubleshooting

### Issue: Vendor store slug not unique
**Solution:**
```bash
php artisan tinker
>>> $vendor = Company::find(123);
>>> $vendor->store_slug = 'unique-slug-name';
>>> $vendor->save();
```

### Issue: Earnings not created for order
**Solution:**
```bash
php artisan tinker
>>> $order = Order::find(123);
>>> app(\App\Services\MultiVendorOrderService::class)->createEarnings($order);
```

### Issue: Vendor stats not updating
**Solution:**
```bash
php artisan tinker
>>> $vendor = Company::find(123);
>>> $vendor->updateStats();
>>> $vendor->updateRating();
```

### Issue: Payout generation fails
**Check:**
1. Are there available earnings for the period?
2. Is the vendor status "active"?
3. Are the dates correct?

---

## 📈 Performance Tips

### 1. Cache Vendor Stats
Run periodically (e.g., daily cron):
```bash
php artisan tinker
>>> Company::where('is_vendor', true)->each->updateStats();
```

### 2. Index Database
Ensure these indexes exist (already in migrations):
- `orders.parent_order_id`
- `orders.company_id`
- `vendor_earnings.company_id`
- `vendor_earnings.status`
- `vendor_payouts.company_id`
- `vendor_payouts.status`

### 3. Eager Load Relationships
```php
// Good
$orders = Order::with('company', 'earnings')->get();

// Bad
$orders = Order::all();
foreach ($orders as $order) {
    $order->company; // N+1 query
}
```

---

## 🔐 Security Notes

1. **Vendor Authorization:**
   - Vendors can only access their own data
   - Use `AuthorizesVendorOrders` trait in controllers

2. **Admin Only:**
   - Payout generation
   - Commission rate changes
   - Vendor approval/suspension

3. **Financial Integrity:**
   - Earnings calculated automatically
   - No manual earning entry
   - Audit trail via payout links

---

## 📞 Support

For detailed documentation, see:
- `MULTI_VENDOR_SYSTEM.md` - Complete system documentation
- `IMPLEMENTATION_SUMMARY.md` - Implementation details

For issues:
1. Check error logs: `storage/logs/laravel.log`
2. Review database migrations
3. Verify relationships in models
4. Test with `php artisan tinker`

---

## 🎉 You're Ready!

The multi-vendor system is now fully operational. Start by:
1. Approving pending vendors
2. Setting commission rates
3. Testing the checkout flow
4. Generating your first payouts

**Happy selling! 🛍️**
