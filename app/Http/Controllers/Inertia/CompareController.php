<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));

        if (empty($ids)) {
            return redirect()->route('products');
        }

        $user = Auth::guard('web')->user();

        $products = Product::with(['images', 'parent', 'features', 'colors'])
            ->whereIn('id', $ids)
            ->withIsInWishlist($user)
            ->get()
            ->map(fn($p) => [
                'id'             => $p->id,
                'name'           => $p->name,
                'slug'           => $p->slug,
                'price'          => (float) $p->price,
                'discount_price' => $p->discount_price ? (float) $p->discount_price : null,
                'image_url'      => $p->image_url,
                'is_in_wishlist' => (bool) $p->is_in_wishlist,
                'quantity'       => $p->quantity,
                'description'    => $p->description,
                'weight'         => $p->weight,
                'parent'         => $p->parent ? ['name' => $p->parent->name] : null,
                'features'       => $p->features->map(fn($f) => [
                    'name'        => $f->feature_name,
                    'description' => $f->feature_description,
                ]),
                'colors'         => $p->colors->map(fn($c) => [
                    'name'       => $c->name,
                    'color_code' => $c->color_code,
                ]),
            ]);

        return Inertia::render('Compare', ['products' => $products]);
    }
}
