<?php

namespace App\Http\Controllers\Vendor;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Choice;
use App\Models\Color;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductAvailability;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{
    use Helper;

    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    protected function authorizeVendorProduct(Product $product): void
    {
        if ((int) $product->company_id !== (int) $this->vendor()->id) {
            abort(404);
        }
    }

    public function fetchChoices()
    {
        $choices = Choice::whereNull('parent_id')->with('children')->get();

        return response()->json($choices);
    }

    public function create()
    {
        $subCategories = MainCategory::whereNull('parent_id')->with('children')->get();
        $colors = Color::all();
        $availability_status = ProductAvailability::all();

        return view('vendor.products.create', compact('subCategories', 'colors', 'availability_status'));
    }

    public function store(ProductRequest $request)
    {
        $request->merge([
            'colors' => $request->input('colors', []),
            'choice_id' => $request->input('choice_id', []),
        ]);

        $data = $request->validated();
        unset($data['company_id']);
        $data['company_id'] = $this->vendor()->id;
        $data['category_id'] = $data['parent_id'];
        $data['slug'] = str_replace(' ', '-', $request->name);

        $request->validate([
            'images' => 'nullable|array',
        ]);

        $data['image'] = $this->uploadedImage($request, 'image', 'products');

        $this->productRepository->store($data);

        return redirect()->route('vendor.products')->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    public function edit(Product $product)
    {
        $this->authorizeVendorProduct($product);

        $product = $product->load('colors', 'choices', 'parent', 'availability', 'features', 'images');

        $subCategories = MainCategory::whereNull('parent_id')->with('children')->get();
        $colors = Color::all();
        $availability_status = ProductAvailability::all();
        $productColors = $product->colors->pluck('id')->toArray();
        $productChoices = $product->choices->pluck('id')->toArray();

        return view('vendor.products.edit', compact(
            'product',
            'subCategories',
            'colors',
            'availability_status',
            'productColors',
            'productChoices'
        ));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorizeVendorProduct($product);

        $request->merge([
            'colors' => $request->input('colors', []),
            'choice_id' => $request->input('choice_id', []),
        ]);

        $data = $request->validated();
        unset($data['company_id']);
        $data['company_id'] = $this->vendor()->id;
        $data['slug'] = str_replace(' ', '-', $request->name);
        $data['category_id'] = $data['parent_id'];

        $this->productRepository->update($data, $product->id);

        return redirect()->route('vendor.products')->with('success', 'تم تحديث المنتج بنجاح.');
    }
}
