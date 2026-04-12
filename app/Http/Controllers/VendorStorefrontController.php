<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;

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

        // Load vendor reviews
        $reviews = $vendor->approvedReviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_products' => $vendor->products()->where('status', 'active')->count(),
            'rating' => $vendor->rating,
            'total_reviews' => $vendor->approvedReviews()->count(),
        ];

        return view('storefront.vendor.show', compact('vendor', 'products', 'reviews', 'stats'));
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
            ->with(['images', 'colors', 'parent']);

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
