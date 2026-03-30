<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected CartRepository $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    // GET /cart — return cart items as JSON
    public function index()
    {
        $items = $this->cart->get()->map(fn($item) => [
            'id'                  => $item->id,
            'product_id'          => $item->product_id,
            'name'                => $item->product?->name,
            'name_en'             => $item->product?->name_en,
            'image'               => $item->product?->image_url,
            'price'               => $item->product?->price,
            'discount_price'      => $item->product?->discount_price,
            'quantity'            => $item->quantity,
        ]);

        return response()->json([
            'items' => $items,
            'count' => $items->count(),
            'total' => $this->cart->total(),
        ]);
    }

    // POST /cart/add
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
            'color_id'   => 'nullable|exists:colors,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity < ($request->quantity ?? 1)) {
            return response()->json(['message' => 'الكمية غير متاحة'], 422);
        }

        try {
            $this->cart->add($product, $request->quantity ?? 1, $request->color_id);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $items = $this->cart->get()->map(fn($item) => [
            'id'             => $item->id,
            'product_id'     => $item->product_id,
            'name'           => $item->product?->name,
            'name_en'        => $item->product?->name_en,
            'image'          => $item->product?->image_url,
            'price'          => $item->product?->price,
            'discount_price' => $item->product?->discount_price,
            'quantity'       => $item->quantity,
        ]);

        return response()->json([
            'message' => 'تم إضافة المنتج للسلة',
            'items'   => $items,
            'count'   => $items->count(),
            'total'   => $this->cart->total(),
        ]);
    }

    // PATCH /cart/{id}
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $this->cart->update($id, $request->quantity);

        $items = $this->cart->get()->map(fn($item) => [
            'id'             => $item->id,
            'product_id'     => $item->product_id,
            'name'           => $item->product?->name,
            'name_en'        => $item->product?->name_en,
            'image'          => $item->product?->image_url,
            'price'          => $item->product?->price,
            'discount_price' => $item->product?->discount_price,
            'quantity'       => $item->quantity,
        ]);

        return response()->json([
            'items' => $items,
            'count' => $items->count(),
            'total' => $this->cart->total(),
        ]);
    }

    // DELETE /cart/{id}
    public function destroy($id)
    {
        $this->cart->delete($id);

        $items = $this->cart->get()->map(fn($item) => [
            'id'             => $item->id,
            'product_id'     => $item->product_id,
            'name'           => $item->product?->name,
            'name_en'        => $item->product?->name_en,
            'image'          => $item->product?->image_url,
            'price'          => $item->product?->price,
            'discount_price' => $item->product?->discount_price,
            'quantity'       => $item->quantity,
        ]);

        return response()->json([
            'items' => $items,
            'count' => $items->count(),
            'total' => $this->cart->total(),
        ]);
    }
}
