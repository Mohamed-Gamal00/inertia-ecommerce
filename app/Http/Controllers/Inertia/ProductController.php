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
        $user  = Auth::guard('web')->user();
        $q     = request('search', '');
        $sort  = request('sort', 'latest');
        $min   = request('min_price');
        $max   = request('max_price');
        $cat   = request('category');

        $query = Product::with(['images', 'parent'])
            ->where('status', 'active')
            ->withIsInWishlist($user);

        if ($q) {
            $query->where(fn($q2) =>
                $q2->where('name', 'LIKE', "%{$q}%")
                   ->orWhere('name_en', 'LIKE', "%{$q}%")
            );
        }

        if ($min) $query->where('price', '>=', $min);
        if ($max) $query->where('price', '<=', $max);
        if ($cat) $query->where('category_id', $cat);

        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'discount'   => $query->whereNotNull('discount_price')->orderByDesc('discount_price'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $products->getCollection()->transform(fn($p) => [
            'id'             => $p->id,
            'name'           => $p->name,
            'name_en'        => $p->name_en,
            'slug'           => $p->slug,
            'price'          => (float) $p->price,
            'discount_price' => $p->discount_price ? (float) $p->discount_price : null,
            'image_url'      => $p->image_url,
            'is_in_wishlist' => (bool) $p->is_in_wishlist,
            'images'         => $p->images->map(fn($i) => ['image_url' => $i->image_url])->values(),
            'parent'         => $p->parent ? ['id' => $p->parent->id, 'name' => $p->parent->name, 'name_en' => $p->parent->name_en] : null,
            'quantity'       => $p->quantity,
        ]);

        $categories = \App\Models\MainCategory::whereNull('parent_id')->select('id', 'name')->get();

        return \Inertia\Inertia::render('Products/Index', [
            'products'   => $products,
            'filters'    => compact('q', 'sort', 'min', 'max', 'cat'),
            'categories' => $categories,
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
