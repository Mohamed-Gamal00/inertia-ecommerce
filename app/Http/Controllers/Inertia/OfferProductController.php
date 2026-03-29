<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OfferProductController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $products = Product::with(['images', 'parent'])
            ->where('status', 'active')
            ->whereNotNull('discount_price')
            ->withIsInWishlist($user)
            ->latest()
            ->paginate(12);

        $products->getCollection()->transform(fn($p) => [
            'id'             => $p->id,
            'name'           => $p->name,
            'name_en'        => $p->name_en,
            'slug'           => $p->slug,
            'price'          => (float) $p->price,
            'discount_price' => (float) $p->discount_price,
            'image_url'      => $p->image_url,
            'is_in_wishlist' => (bool) $p->is_in_wishlist,
            'images'         => $p->images->map(fn($i) => ['image_url' => $i->image_url])->values(),
            'parent'         => $p->parent ? ['id' => $p->parent->id, 'name' => $p->parent->name, 'name_en' => $p->parent->name_en] : null,
            'quantity'       => $p->quantity,
        ]);

        return Inertia::render('Offers/Index', ['products' => $products]);
    }
}
