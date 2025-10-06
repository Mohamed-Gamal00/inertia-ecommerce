<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // هنا بنجيب المنتجات، تقدر تخصصها حسب احتياجك
//        $products = Product::query()
//            ->latest()
//            ->take(10)
//            ->get();
        $products = Product::with('images')->latest()->take(10)->get();

        // بنرجعها كـ props لـ Vue
        return Inertia::render('Home', [
            'products' => $products,
        ]);
    }
}
