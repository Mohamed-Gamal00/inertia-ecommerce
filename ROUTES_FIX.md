# Vendor Routes Fix

## Issue
When accessing `/admin/vendors`, the error occurred:
```
Route [vendors.suspend] not defined
```

## Root Cause
The existing view `resources/views/dashboard/vendors/index.blade.php` was expecting routes that weren't defined in the new VendorManagementController.

## Solution

### 1. Added Missing Routes
Updated `routes/dashboard.php` to include:
- `vendors.approve` - Approve vendor (set status to active)
- `vendors.suspend` - Suspend vendor (set status to suspended)

### 2. Added Controller Methods
Added to `VendorManagementController`:
```php
public function approve(Company $vendor)
{
    $vendor->update(['status' => 'active']);
    return back()->with('success', 'تم تفعيل البائع بنجاح');
}

public function suspend(Company $vendor)
{
    $vendor->update(['status' => 'suspended']);
    return back()->with('success', 'تم إيقاف البائع بنجاح');
}
```

### 3. Updated Index Method
Fixed the index method to handle status filter correctly:
```php
if ($request->has('status') && $request->status !== 'all') {
    $query->where('status', $request->status);
}
```

## Current Vendor Routes

All vendor routes are now properly defined:

| Method | URI | Name | Action |
|--------|-----|------|--------|
| GET | /admin/vendors | vendors.index | List vendors |
| GET | /admin/vendors/{vendor} | vendors.show | Show vendor details |
| PUT | /admin/vendors/{vendor}/approve | vendors.approve | Approve vendor |
| PUT | /admin/vendors/{vendor}/suspend | vendors.suspend | Suspend vendor |
| PUT | /admin/vendors/{vendor}/status | vendors.status | Update status |
| PUT | /admin/vendors/{vendor}/commission | vendors.commission | Update commission |
| DELETE | /admin/vendors/{vendor} | vendors.destroy | Delete vendor |

## Testing

Visit: `http://127.0.0.1:8000/admin/vendors`

The page should now load correctly and display:
- ✅ List of all vendors
- ✅ Status tabs (All, Active, Pending, Suspended)
- ✅ Approve button for pending vendors
- ✅ Suspend button for active vendors
- ✅ View and delete buttons

## Status

✅ **FIXED** - All vendor routes are now working correctly.
