<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryController extends Controller
{
    // عرض صفحة جميع الأقسام (لو عايز صفحة مستقلة)
    public function index()
    {
        $categories = MainCategory::select('id', 'name', 'slug', 'image')->get()->map(fn($c) => [
            'id'        => $c->id,
            'name'      => $c->name,
            'slug'      => $c->slug,
            'image_url' => $c->image ? Storage::url($c->image) : null,
        ]);

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
            'category' => [
                'id'          => $category->id,
                'name'        => $category->name,
                'name_en'     => $category->name_en,
                'slug'        => $category->slug,
                'description' => $category->description,
                'image_url'   => $category->image_url,
            ],
            'products' => $products,
        ]);
    }

}
