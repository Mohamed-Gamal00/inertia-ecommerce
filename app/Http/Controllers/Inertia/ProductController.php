<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Resources\ViewProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
//    public function index()
//    {
//        $user = Auth::guard('web')->user();
//
//        $allProducts = \App\Models\Product::with(['availability', 'parent', 'images'])
//            ->paginate(5);
//        // نضيف is_in_wishlist لكل منتج
//        if ($user) {
//            $wishlistIds = $user->wishlistProducts()->pluck('product_id')->toArray();
//
//            $allProducts->getCollection()->transform(function ($product) use ($wishlistIds) {
//                $product->is_in_wishlist = in_array($product->id, $wishlistIds);
//                return $product;
//            });
//        } else {
//            $allProducts->getCollection()->transform(function ($product) {
//                $product->is_in_wishlist = false;
//                return $product;
//            });
//        }
//
//        return \Inertia\Inertia::render('Products/Index', [
//            'products' => $allProducts,
//        ]);
//    }

    public function index()
    {
        $user = Auth::guard('web')->user();

        $products = Product::with(['images', 'parent'])
            ->withIsInWishlist($user)
            ->latest()
            ->paginate(5);

        return \Inertia\Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'parent', 'features'])->where('slug', $slug)->firstOrFail();
        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }
}
