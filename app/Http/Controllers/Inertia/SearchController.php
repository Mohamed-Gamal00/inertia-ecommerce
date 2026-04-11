<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q    = $request->input('q', '');
        $sort = $request->input('sort', 'latest');
        $min  = $request->input('min_price');
        $max  = $request->input('max_price');
        $cat  = $request->input('category');

        $query = Product::with(['images', 'parent'])
            ->where('status', 'active')
            ->withIsInWishlist(Auth::guard('web')->user());

        if ($q) {
            $query->where(fn($q2) =>
                $q2->where('name', 'LIKE', "%{$q}%")
                   ->orWhere('name_en', 'LIKE', "%{$q}%")
                   ->orWhere('description', 'LIKE', "%{$q}%")
            );
        }

        if ($min) $query->where('price', '>=', $min);
        if ($max) $query->where('price', '<=', $max);
        if ($cat) $query->where('category_id', $cat);

        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };

        // For live search — return JSON when called via AJAX or explicitly requesting JSON
        if ($request->wantsJson() || $request->ajax() || $request->hasHeader('X-Requested-With')) {
            return response()->json(
                $query->take(8)->get()->map(fn($p) => [
                    'id'             => $p->id,
                    'name'           => $p->name,
                    'slug'           => $p->slug,
                    'price'          => (float) $p->price,
                    'discount_price' => $p->discount_price ? (float) $p->discount_price : null,
                    'image_url'      => $p->image_url,
                ])
            );
        }

        // For full search page — redirect to products with filters
        return redirect("/products?search={$q}&sort={$sort}");
    }
}
