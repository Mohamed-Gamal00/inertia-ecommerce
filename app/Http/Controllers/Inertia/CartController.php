<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CartController extends Controller
{
    protected CartRepository $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Map cart items to the JSON structure expected by the frontend.
     */
    protected function mapItems($items)
    {
        return $items->map(fn($item) => [
            'id'             => $item->id,
            'product_id'     => $item->product_id,
            'name'           => $item->product?->name,
            'name_en'        => $item->product?->name_en,
            'image'          => $item->product?->image_url,
            'price'          => $item->product?->price,
            'discount_price' => $item->product?->discount_price,
            'quantity'       => $item->quantity,
        ]);
    }

    /**
     * Build the standard JSON cart response.
     */
    protected function cartResponse(string $message = null): array
    {
        $items = $this->cart->get();

        $response = [
            'items' => $this->mapItems($items),
            'count' => $items->count(),
            'total' => $this->cart->total(),
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return $response;
    }

    // GET /cart — return cart items as JSON
    public function index()
    {
        return response()->json($this->cartResponse());
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

        $quantity = $request->quantity ?? 1;

        // Pre-check: the product must have at least one unit in stock.
        if ($product->quantity < 1) {
            return response()->json(['message' => __('flash.quantity_not_available')], 422);
        }

        try {
            $this->cart->add($product, $quantity, $request->color_id);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(
            $this->cartResponse(__('flash.product_added_to_cart'))
        );
    }

    // PATCH /cart/{id}
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        try {
            $this->cart->update($id, $request->quantity);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($this->cartResponse());
    }

    // DELETE /cart/{id}
    public function destroy($id)
    {
        $this->cart->delete($id);

        return response()->json($this->cartResponse());
    }
}
