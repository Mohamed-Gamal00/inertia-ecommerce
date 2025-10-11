<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Resources\ViewProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $allProducts = Product::with(['availability','parent','images'])->paginate(5);
        return Inertia::render('Products/Index', [
            'products' => $allProducts,
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'parent'])->where('slug', $slug)->firstOrFail();
        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }
}
