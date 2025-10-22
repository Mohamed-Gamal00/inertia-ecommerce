<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    // عرض صفحة جميع الأقسام (لو عايز صفحة مستقلة)
    public function index()
    {
        $categories = MainCategory::select('id', 'name', 'slug')->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function show($slug)
    {
        $category = \App\Models\MainCategory::where('slug', $slug)->firstOrFail();
        $user = Auth::guard('web')->user();
        $products = $category->products()->with(['images', 'parent'])->withIsInWishlist($user)->latest()->get();

        return \Inertia\Inertia::render('Categories/Show', [
            'category' => $category,
            'products' => $products,
        ]);
    }

}
