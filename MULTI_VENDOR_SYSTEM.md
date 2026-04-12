# Multi-Vendor E-Commerce System

## Overview
This document describes the professional multi-vendor marketplace features implemented in this Laravel e-commerce platform.

## Features Implemented

### 1. Multi-Vendor Order Splitting
**Problem Solved:** Customers can now purchase from multiple vendors in a single checkout.

**How it works:**
- When a cart contains products from multiple vendors, the system automatically creates:
  - One **parent order** (visible to customer, contains total payment)
  - Multiple **sub-orders** (one per vendor, for fulfillment)
- Each vendor only sees and manages their own sub-orders
- Payment is handled at the parent order level
- Earnings are automatically calculated per vendor

**Database Changes:**
- `orders.parent_order_id` - Links sub-orders to parent
- `orders.is_parent` - Identifies parent orders
- `orders.company_id` - Vendor assignment for sub-orders

### 2. Vendor Public Storefront & Branding
**Problem Solved:** Each vendor has a professional public-facing store with custom branding.

**Features:**
- Custom store URL: `/store/{vendor-slug}`
- Vendor branding:
  - Logo (`image`)
  - Cover banner (`cover_image`)
  - Brand color (`banner_color`)
  - Social media links (Instagram, Twitter, Facebook, WhatsApp)
- Store policies:
  - Return policy
  - Shipping policy
- Vendor rating and reviews
- Product catalog filtered by vendor

**Database Changes:**
- `companies.store_slug` - Unique URL-friendly store identifier
- `companies.cover_image` - Store banner
- `companies.banner_color` - Brand color
- `companies.social_links` - JSON field for social media
- `companies.return_policy` - Vendor-specific return policy
- `companies.shipping_policy` - Vendor-specific shipping policy
- `companies.rating` - Average vendor rating
- `companies.total_sales` - Cached sales count
- `companies.total_products` - Cached product count

### 3. Commission & Payout System
**Problem Solved:** Automated financial tracking between platform and vendors.

**Features:**
- Configurable commission rate per vendor (default 10%)
- Automatic earnings calculation on each order
- Earnings status tracking:
  - `pending` - Order not yet paid
  - `available` - Ready for payout
  - `paid` - Already paid to vendor
- Payout generation for specific periods
- Admin can mark payouts as paid with transaction reference
- Vendor dashboard shows:
  - Available balance
  - Pending balance
  - Total paid
  - Commission breakdown

**Database Tables:**
- `vendor_earnings` - Tracks each order item's commission split
- `vendor_payouts` - Groups earnings into payout batches
- `vendor_reviews` - Customer reviews for vendors

**Key Fields:**
- `companies.commission_rate` - Platform commission percentage
- `companies.bank_account` - Vendor bank details
- `companies.bank_name` - Vendor bank name
- `companies.business_license` - Business registration
- `companies.tax_number` - Tax ID

### 4. Enhanced Vendor Reports
**Problem Solved:** Vendors need detailed analytics and financial reports.

**Features:**
- Revenue analytics (total, monthly, daily)
- Order statistics
- Top-selling products
- Customer analytics (top customers by spending)
- Sales trends over time
- Commission breakdown
- Export to CSV
- Date range filtering

**Available Reports:**
- Total revenue
- Total orders
- Items sold
- Available balance
- Pending balance
- Total paid out
- Commission paid
- Top 5 products
- Top 10 customers
- 30-day sales chart

### 5. Admin Vendor Management
**Problem Solved:** Platform admins need control over vendors and payouts.

**Admin Features:**
- Vendor listing with search and filters
- Vendor approval/suspension
- Commission rate management per vendor
- Vendor statistics dashboard
- Payout generation (single vendor or all vendors)
- Payout approval and processing
- Transaction reference tracking
- Vendor deletion (with safety checks)

**Admin Routes:**
- `/admin/vendors` - List all vendors
- `/admin/vendors/{id}` - Vendor details
- `/admin/vendors/{id}/status` - Update vendor status
- `/admin/vendors/{id}/commission` - Update commission rate
- `/admin/payouts` - List all payouts
- `/admin/payouts/generate` - Generate new payouts
- `/admin/payouts/{id}/mark-paid` - Mark payout as paid

## Usage Guide

### For Vendors

#### 1. Register as Vendor
```
POST /vendor/register
- name, email, password, phone, description
- Status starts as 'pending' (requires admin approval)
```

#### 2. Setup Store Branding
```
PUT /vendor/profile
- Upload logo and cover image
- Set store slug (URL)
- Add social media links
- Configure return/shipping policies
- Add bank account details
```

#### 3. View Earnings
```
GET /vendor/payouts
- See available balance
- View payout history
- Track commission breakdown
```

#### 4. Generate Reports
```
GET /vendor/reports
- Filter by date range
- Export to CSV
- View top products and customers
```

### For Admins

#### 1. Approve Vendors
```
PUT /admin/vendors/{id}/status
body: { status: 'active' }
```

#### 2. Set Commission Rate
```
PUT /admin/vendors/{id}/commission
body: { commission_rate: 15.00 }
```

#### 3. Generate Payouts
```
POST /admin/payouts/generate
body: {
  period_start: '2026-01-01',
  period_end: '2026-01-31',
  vendor_id: 123 (optional, leave empty for all vendors)
}
```

#### 4. Mark Payout as Paid
```
PUT /admin/payouts/{id}/mark-paid
body: {
  transaction_reference: 'TXN123456',
  notes: 'Paid via bank transfer'
}
```

### For Customers

#### 1. Browse Vendor Store
```
GET /store/{vendor-slug}
- View vendor profile
- Browse vendor products
- Read vendor reviews
```

#### 2. Multi-Vendor Checkout
- Add products from multiple vendors to cart
- Checkout once
- System automatically splits order by vendor
- Each vendor fulfills their portion

## Database Schema

### New Tables
1. `vendor_earnings` - Individual order item earnings
2. `vendor_payouts` - Payout batches
3. `vendor_reviews` - Customer reviews for vendors

### Modified Tables
1. `orders` - Added `parent_order_id`, `is_parent`
2. `companies` - Added 15+ branding and financial fields

## Services

### MultiVendorOrderService
- `createMultiVendorOrder()` - Splits cart into vendor orders
- `createEarnings()` - Calculates vendor earnings
- `updateEarningsStatus()` - Updates earnings when payment status changes

### VendorPayoutService
- `generatePayout()` - Creates payout for vendor
- `markAsPaid()` - Marks payout as paid
- `getAvailableBalance()` - Gets vendor available balance
- `generatePayoutsForAllVendors()` - Batch payout generation

## Observers

### OrderObserver
- Automatically updates earnings status when order payment status changes

### CompanyObserver
- Auto-generates unique store slugs for vendors
- Ensures slug uniqueness on create/update

## API Endpoints

### Public
- `GET /store/{slug}` - Vendor storefront
- `GET /store/{slug}/products` - Vendor products (AJAX)

### Vendor (Auth: vendor guard)
- `GET /vendor/payouts` - Payout list
- `GET /vendor/payouts/{id}` - Payout details
- `GET /vendor/earnings` - Earnings history
- `GET /vendor/reports` - Analytics dashboard
- `GET /vendor/reports/export` - Export CSV
- `GET /vendor/profile/edit` - Edit profile
- `PUT /vendor/profile` - Update profile

### Admin (Auth: admin guard)
- `GET /admin/vendors` - Vendor list
- `GET /admin/vendors/{id}` - Vendor details
- `PUT /admin/vendors/{id}/status` - Update status
- `PUT /admin/vendors/{id}/commission` - Update commission
- `GET /admin/payouts` - Payout list
- `POST /admin/payouts/generate` - Generate payouts
- `PUT /admin/payouts/{id}/mark-paid` - Mark as paid

## Migration Instructions

1. **Run migrations:**
```bash
php artisan migrate
```

2. **Update existing vendors:**
```bash
php artisan tinker
Company::where('is_vendor', true)->each(function($vendor) {
    $vendor->store_slug = Str::slug($vendor->name);
    $vendor->commission_rate = 10.00;
    $vendor->save();
});
```

3. **Create earnings for existing orders:**
```bash
php artisan tinker
$service = app(\App\Services\MultiVendorOrderService::class);
Order::where('payment_status', 'paid')->whereNotNull('company_id')->each(function($order) use ($service) {
    $service->createEarnings($order);
});
```

## Configuration

### Commission Rates
Default commission rate is 10%. Can be customized per vendor in admin panel.

### Payout Periods
Recommended: Monthly payouts (1st to last day of month)

### Vendor Status
- `pending` - Awaiting admin approval
- `active` - Can sell products
- `suspended` - Temporarily disabled

## Security Considerations

1. **Vendor Authorization:**
   - Vendors can only see their own orders, products, earnings
   - `AuthorizesVendorOrders` trait enforces this

2. **Admin Controls:**
   - Only admins can approve vendors
   - Only admins can generate and approve payouts
   - Commission rates controlled by admin

3. **Financial Integrity:**
   - Earnings calculated automatically (no manual entry)
   - Payouts linked to specific earnings (audit trail)
   - Transaction references required for paid payouts

## Testing Checklist

- [ ] Vendor registration and approval flow
- [ ] Multi-vendor cart checkout
- [ ] Order splitting by vendor
- [ ] Earnings calculation accuracy
- [ ] Commission rate application
- [ ] Payout generation
- [ ] Vendor storefront display
- [ ] Vendor profile updates
- [ ] Report generation and export
- [ ] Admin vendor management
- [ ] Payment status updates trigger earnings updates

## Future Enhancements

1. **Vendor Subscription Plans** - Different commission tiers
2. **Automated Payouts** - Integration with payment gateways
3. **Vendor Analytics Dashboard** - Real-time charts
4. **Multi-Currency Support** - Per-vendor currency
5. **Vendor Messaging** - Customer-vendor chat
6. **Vendor Shipping Zones** - Custom shipping per vendor
7. **Vendor Promotions** - Vendor-specific sales/coupons
8. **Vendor Performance Metrics** - Response time, fulfillment rate

## Support

For questions or issues, contact the development team or refer to the Laravel documentation.
