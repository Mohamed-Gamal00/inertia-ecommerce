<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorStorefrontController extends Controller
{
    /**
     * Show vendor public storefront
     */
    public function show($slug)
    {
        $vendor = Company::where('store_slug', $slug)
            ->where('is_vendor', true)
            ->where('status', 'active')
            ->firstOrFail();

        // Load vendor products
        $products = Product::where('company_id', $vendor->id)
            ->where('status', 'active')
            ->with(['images', 'colors', 'parent'])
            ->paginate(12);

        // Transform products for frontend
        $products->getCollection()->transform(fn($p) => [
            'id'             => $p->id,
            'name'           => $p->name,
            'name_en'        => $p->name_en,
            'slug'           => $p->slug,
            'price'          => (float) $p->price,
            'discount_price' => $p->discount_price ? (float) $p->discount_price : null,
            'image_url'      => $p->image_url,
            'is_in_wishlist' => false,
            'images'         => $p->images->map(fn($i) => ['image_url' => $i->image_url])->values(),
            'parent'         => $p->parent ? [
                'id' => $p->parent->id,
                'name' => $p->parent->name,
                'name_en' => $p->parent->name_en
            ] : null,
            'quantity'       => $p->quantity,
            'company'        => [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'name_en' => $vendor->name_en,
                'store_slug' => $vendor->store_slug,
            ],
        ]);

        // Load vendor reviews
        $reviews = $vendor->approvedReviews()
            ->with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'rating' => $r->rating,
                'comment' => $r->comment,
                'created_at' => $r->created_at,
                'user' => $r->user ? [
                    'name' => $r->user->name,
                ] : null,
            ]);

        $stats = [
            'total_products' => $vendor->products()->where('status', 'active')->count(),
            'rating' => round($vendor->rating ?? 0, 1),
            'total_reviews' => $vendor->approvedReviews()->count(),
        ];

        // Prepare vendor data
        $vendorData = [
            'id' => $vendor->id,
            'name' => $vendor->getCurrentNameLangAttribute(),
            'name_ar' => $vendor->name,
            'name_en' => $vendor->name_en,
            'slug' => $vendor->store_slug,
            'description' => $vendor->description,
            'image_url' => $vendor->image_url,
            'cover_image_url' => $vendor->cover_image_url,
            'banner_color' => $vendor->banner_color ?? '#1a237e',
            'email' => $vendor->email,
            'phone' => $vendor->phone,
            'social_links' => $vendor->social_links ?? [],
            'return_policy' => $vendor->return_policy,
            'shipping_policy' => $vendor->shipping_policy,
            'rating' => $stats['rating'],
            'status' => $vendor->status,
            'business_hours' => $vendor->business_hours ?? null,
        ];

        return Inertia::render('Store/Show', [
            'vendor' => $vendorData,
            'products' => $products,
            'reviews' => $reviews,
            'stats' => $stats,
        ]);
    }

    /**
     * Show vendor products (AJAX/API)
     */
    public function products($slug, Request $request)
    {
        $vendor = Company::where('store_slug', $slug)
            ->where('is_vendor', true)
            ->where('status', 'active')
            ->firstOrFail();

        $query = Product::where('company_id', $vendor->id)
            ->where('status', 'active')
            ->with(['images', 'colors', 'parent', 'company']);

        // Filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('sort')) {
            match($request->sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest(),
                default => $query->latest(),
            };
        }

        $products = $query->paginate(12);

        return response()->json($products);
    }
}
