<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Resources\HeaderBannerResource;
use App\Models\Design;
use App\Models\HeaderBanner;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $products = Product::with(['images', 'parent'])
            ->withIsInWishlist($user)
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($p) => [
                'id'             => $p->id,
                'name'           => $p->name,
                'name_en'        => $p->name_en,
                'slug'           => $p->slug,
                'price'          => $p->price,
                'discount_price' => $p->discount_price,
                'image_url'      => $p->image_url,
                'is_in_wishlist' => (bool) $p->is_in_wishlist,
                'quantity'       => (int) $p->quantity,
                'images'         => $p->images->map(fn($img) => ['image_url' => $img->image_url])->values(),
                'parent'         => $p->parent
                    ? ['id' => $p->parent->id, 'name' => $p->parent->name, 'name_en' => $p->parent->name_en]
                    : null,
            ]);

        $banners = HeaderBannerResource::collection(HeaderBanner::all())->resolve();

        $homeDesigns = Design::where('page_name', 'home')
            ->whereIn('title', ['home_band_left', 'home_band_right', 'home_tv_banner'])
            ->get()
            ->keyBy('title')
            ->map(fn($d) => $d->image_url);

        return Inertia::render('Home', [
            'products'    => $products,
            'banners'     => $banners,
            'homeDesigns' => $homeDesigns,
        ]);
    }
}
