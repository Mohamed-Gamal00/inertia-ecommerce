<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        // جلب أحدث 10 منتجات مع العلاقات
        $products = Product::with(['images', 'parent'])
            ->withIsInWishlist($user)
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Home', [
            'products' => $products,
        ]);
    }
}
