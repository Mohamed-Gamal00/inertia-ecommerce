# TopOffers Dynamic Implementation

## Overview
Converted TopOffers component from static images to dynamic database-driven content using the `designs` table.

## Changes Made

### 1. Database Structure
**Table**: `designs`
**Fields used**:
- `id`: Primary key
- `title`: Identifier (top_offer_1, top_offer_2, etc.)
- `page_name`: 'home'
- `image`: Image path
- `description`: Optional description/alt text

### 2. Backend Changes

#### HomeController.php
Added query to fetch top offers:
```php
$topOffers = Design::where('page_name', 'home')
    ->whereIn('title', ['top_offer_1', 'top_offer_2', 'top_offer_3', 'top_offer_4', 'top_offer_5'])
    ->orderBy('title')
    ->get()
    ->map(fn($d) => [
        'id' => $d->id,
        'title' => $d->title,
        'image_url' => $d->image_url,
        'description' => $d->description,
    ]);
```

Passed to Inertia:
```php
return Inertia::render('Home', [
    'products'    => $products,
    'banners'     => $banners,
    'homeDesigns' => $homeDesigns,
    'topOffers'   => $topOffers, // NEW
]);
```

### 3. Frontend Changes

#### TopOffers.vue Component
- Converted from static to dynamic data
- Uses `usePage().props.topOffers`
- Split into `topRow` (first 3) and `bottomRow` (2 large images)
- Maintains hover effects and responsive layout
- Shows nothing if no offers available

## Setup Instructions

### Step 1: Run the Seeder (Optional)
```bash
php artisan db:seed --class=TopOffersSeeder
```

### Step 2: Add Images via Admin Panel
Navigate to Admin → Designs → Add/Edit designs with these titles:
- `top_offer_1` (Top row, left)
- `top_offer_2` (Top row, center)
- `top_offer_3` (Top row, right)
- `top_offer_4` (Bottom row, left - large)
- `top_offer_5` (Bottom row, right - large)

**Important**: 
- Set `page_name` to `home`
- Upload images to `public/storage/designs/`
- Add descriptions for alt text (optional)

### Step 3: Image Requirements
- **Top row images**: Landscape format, ~600x400px recommended
- **Bottom row images**: Wider landscape, ~800x500px recommended
- Format: JPG, PNG, or WebP
- Max size: 2MB recommended

## Layout Structure

```
┌─────────────────────────────────────────────┐
│  [Offer 1]  [Offer 2]  [Offer 3]           │ ← Top row (3 images)
│                                              │
│  [   Offer 4   ]  [   Offer 5   ]          │ ← Bottom row (2 large)
└─────────────────────────────────────────────┘
```

## Responsive Behavior
- **Desktop**: 3 columns top, 2 columns bottom
- **Tablet**: 2 columns top, 1 column bottom stacked
- **Mobile**: 1 column, all stacked

## Admin Management

### To add/update offers:
1. Go to Admin Dashboard → Designs
2. Create/Edit design with:
   - **Title**: `top_offer_1` through `top_offer_5`
   - **Page Name**: `home`
   - **Image**: Upload your offer image
   - **Description**: Brief description (shows as alt text)

### To remove offers:
- Delete the design record or leave image empty
- Component will automatically hide if no offers exist

## Benefits
✅ **Easy Management**: Update offers from admin panel
✅ **No Code Changes**: Change images without touching code
✅ **Flexible**: Can have 0-5 offers, component adapts
✅ **SEO Friendly**: Alt text from descriptions
✅ **Responsive**: Works on all screen sizes

## Files Modified
1. `app/Http/Controllers/Inertia/HomeController.php` - Added topOffers query
2. `resources/js/components/home_page/TopOffers.vue` - Made dynamic
3. `database/seeders/TopOffersSeeder.php` - Created seeder (NEW)
