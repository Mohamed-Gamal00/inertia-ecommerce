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
        'test ';
        $allProducts = Product::with('availability')->paginate(5);
        return Inertia::render('Products', [
            'products' => $allProducts,
        ]);
    }
}
