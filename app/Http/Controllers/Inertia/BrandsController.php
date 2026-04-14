<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Inertia\Inertia;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Company::withCount('products')->get()->map(fn($c) => [
            'id'            => $c->id,
            'name'          => $c->name,
            'name_en'       => $c->name_en,
            'image_url'     => $c->image_url,
            'products_count'=> $c->products_count,
            'store_slug'    => $c->store_slug,
            'is_vendor'     => $c->is_vendor,
        ]);

        return Inertia::render('Brands/Index', ['brands' => $brands]);
    }

    public function show($id)
    {
        $company  = Company::findOrFail($id);
        $products = $company->products()->with(['images', 'parent'])
            ->where('status', 'active')
            ->withIsInWishlist(null)
            ->latest()
            ->paginate(12);

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
            'parent'         => $p->parent ? ['id' => $p->parent->id, 'name' => $p->parent->name, 'name_en' => $p->parent->name_en] : null,
            'quantity'       => $p->quantity,
        ]);

        return Inertia::render('Brands/Show', [
            'brand'    => ['id' => $company->id, 'name' => $company->name, 'name_en' => $company->name_en, 'image_url' => $company->image_url],
            'products' => $products,
        ]);
    }
}
