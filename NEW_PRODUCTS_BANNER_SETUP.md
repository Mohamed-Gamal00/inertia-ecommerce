# NewProducts Banner - Dynamic Implementation

## Overview
Converted the NewProducts section banner from static image to dynamic database-driven content and updated colors to match Vanilla Latte theme.

## Changes Made

### 1. Backend Changes

#### HomeController.php
Added query to fetch new products banner:
```php
$newProductsBanner = Design::where('page_name', 'home')
    ->where('title', 'new_products_banner')
    ->first();
```

Passed to Inertia:
```php
'newProductsBanner' => $newProductsBanner ? $newProductsBanner->image_url : null,
```

### 2. Frontend Changes

#### NewProducts.vue Component
- **Dynamic Banner**: Now uses `newProductsBanner` from page props
- **Conditional Rendering**: Only shows banner if image exists
- **Responsive Design**: Proper scaling on all screen sizes
- **Vanilla Latte Colors**:
  - Title: Primary Text (#302F2B)
  - Shop All link: Mocha Brown (#76543D) with Caramel (#C69763) hover
  - Pagination bullets: Border Beige inactive, Mocha Brown active
- **Hover Effects**: Smooth underline animation on "Shop All" link
- **Image Styling**: Rounded corners, hover zoom effect

### 3. Database Structure

**Table**: `designs`
**New Record**:
- `title`: 'new_products_banner'
- `page_name`: 'home'
- `image`: Path to banner image
- `description`: 'New Products Section Banner'

## Setup Instructions

### Method 1: Via Admin Panel (Recommended)
1. Go to Admin → Designs
2. Create a new design:
   - **Title**: `new_products_banner`
   - **Page Name**: `home`
   - **Image**: Upload your banner image (vertical/portrait format)
   - **Description**: Add description (optional)

### Method 2: Run Updated Seeder
```bash
php artisan db:seed --class=TopOffersSeeder
```

## Image Requirements

### New Products Banner:
- **Format**: Portrait/Vertical orientation
- **Recommended Size**: 800x1000px or similar ratio
- **Aspect Ratio**: ~4:5 or 3:4
- **File Type**: JPG, PNG, or WebP
- **Max Size**: 2MB recommended
- **Content**: Should complement product showcase

## Color System Applied

### Title Section:
- **Title Color**: #302F2B (Primary Text)
- **Font Weight**: 900
- **Responsive**: 30px → 26px → 22px

### Shop All Link:
- **Default**: #76543D (Mocha Brown)
- **Hover**: #C69763 (Caramel)
- **Underline Animation**: Expands from left to right
- **Font Weight**: 600

### Pagination:
- **Inactive Bullets**: #D7CDBD (Border Beige)
- **Active Bullet**: #76543D (Mocha Brown)

### Banner Wrapper:
- **Border Radius**: 12px
- **Min Height**: 300px (desktop), 250px (tablet), 200px (mobile)
- **Hover Effect**: Gentle scale (1.02)

## Layout Structure

```
┌──────────────────────────────────────────┐
│  All Products            Shop All →      │ ← Header
├──────────────────────────────────────────┤
│                              │           │
│  [Product] [Product]         │   Banner  │
│  [Product] [Product]         │   Image   │
│  [Product] [Product]         │  (Dynamic)│
│                              │           │
│  ● ● ● (Pagination)          │           │
└──────────────────────────────────────────┘
```

## Responsive Behavior

- **Desktop (≥1280px)**: Banner on right, 4 products per row
- **Tablet (960px-1279px)**: Banner on right, 3 products per row
- **Small Tablet (600px-959px)**: Banner below, 2 products per row
- **Mobile (<600px)**: Banner below, 2 products per row

## Benefits

✅ **Easy Updates**: Change banner via admin panel
✅ **No Code Changes**: Update images without deploying
✅ **Consistent Design**: Matches Vanilla Latte theme
✅ **Responsive**: Works on all screen sizes
✅ **Performance**: Optimized image loading
✅ **SEO Friendly**: Proper alt text and descriptions

## Files Modified

1. `app/Http/Controllers/Inertia/HomeController.php` - Added banner query
2. `resources/js/components/home_page/NewProducts.vue` - Made dynamic + color updates
3. `database/seeders/TopOffersSeeder.php` - Added banner record

## Admin Management

### To add/update banner:
1. Admin Dashboard → Designs → Create/Edit
2. Set **Title**: `new_products_banner`
3. Set **Page Name**: `home`
4. Upload image
5. Save

### To remove banner:
- Delete the design record or remove the image
- Component will automatically hide the banner column

## Testing

After setup, verify:
1. Banner appears on home page (right side on desktop)
2. Banner is responsive on mobile
3. Hover effects work smoothly
4. Colors match Vanilla Latte theme
5. "Shop All" link has underline animation

## Color Consistency

All colors now match the Vanilla Latte system:
- Mocha Brown (#76543D) for primary actions
- Caramel (#C69763) for hover states
- Primary Text (#302F2B) for headings
- Border Beige (#D7CDBD) for subtle elements
