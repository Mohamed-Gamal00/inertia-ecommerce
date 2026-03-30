<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeRequest;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Repositories\Discount_codes\DiscountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDiscountCodeController extends Controller
{
    protected $discountRepository;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    protected function authorizeVendorDiscountCode(DiscountCode $discountCode): void
    {
        if ((int) $discountCode->company_id !== (int) $this->vendor()->id) {
            abort(404);
        }
    }

    public function index()
    {
        $discounts = $this->discountRepository->getVendorDiscountCodes($this->vendor()->id);
        return view('vendor.discount_codes.index', compact('discounts'));
    }

    public function create()
    {
        $products = Product::where('company_id', $this->vendor()->id)->select('id', 'name')->get();
        return view('vendor.discount_codes.create', compact('products'));
    }

    public function searchProducts(Request $request)
    {
        $search = $request->input('q', '');
        $products = Product::where('company_id', $this->vendor()->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name')
            ->take(10)
            ->get();

        return response()->json($products->map(fn($p) => ['id' => $p->id, 'text' => $p->name]));
    }

    public function store(DiscountCodeRequest $request)
    {
        $validatedData = $request->validated();
        $productIds = $request->has('product_ids') ? $validatedData['product_ids'] : [];
        unset($validatedData['product_ids']);

        $validatedData['company_id'] = $this->vendor()->id;

        $discountCode = $this->discountRepository->store($validatedData);

        if ($discountCode && !empty($productIds)) {
            // Ensure vendor only attaches their own products
            $ownedProductIds = Product::where('company_id', $this->vendor()->id)
                ->whereIn('id', $productIds)
                ->pluck('id')
                ->toArray();
            $discountCode->products()->sync($ownedProductIds);
        }

        return redirect()->route('vendor.discount_code.index')->with('success', 'تم إنشاء كوبون الخصم بنجاح.');
    }

    public function edit($id)
    {
        $discountCode = DiscountCode::findOrFail($id);
        $this->authorizeVendorDiscountCode($discountCode);

        $products = Product::where('company_id', $this->vendor()->id)->select('id', 'name')->latest()->take(10)->get();
        $discountProductsIds = $discountCode->products->pluck('id')->toArray();

        return view('vendor.discount_codes.edit', compact('discountCode', 'products', 'discountProductsIds'));
    }

    public function update(DiscountCodeRequest $request, $id)
    {
        $discountCode = DiscountCode::findOrFail($id);
        $this->authorizeVendorDiscountCode($discountCode);

        $data = $request->validated();
        $productIds = $data['product_ids'] ?? [];
        unset($data['product_ids']);

        $wasChanged = $this->discountRepository->update($data, $id);

        if (!empty($productIds)) {
            $ownedProductIds = Product::where('company_id', $this->vendor()->id)
                ->whereIn('id', $productIds)
                ->pluck('id')
                ->toArray();
            $this->discountRepository->syncProducts($id, $ownedProductIds);
        }

        return redirect()->route('vendor.discount_code.index')->with('success', 'تم تحديث كوبون الخصم بنجاح.');
    }

    public function destroy($id)
    {
        $discountCode = DiscountCode::findOrFail($id);
        $this->authorizeVendorDiscountCode($discountCode);

        $this->discountRepository->delete($id);
        return redirect()->route('vendor.discount_code.index')->with('success', 'تم حذف كوبون الخصم بنجاح.');
    }
}
