<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function add(Product $product, $quantity = 1, $color_id = null)
    {
        $item = Cart::where('product_id', '=', $product->id)
            ->where('status', 0)
            ->first();

        if (!$item) {
            Cart::create([
                'user_id'    => Auth::guard('web')->user()->id ?? null,
                'product_id' => $product->id,
                'status'     => 0,
                'quantity'   => $quantity,
                'color_id'   => $color_id,
            ]);
        } else {
            if ($item->quantity >= $product->quantity) {
                return null;
            }
            $item->increment('quantity', $quantity);
        }

        // Reset cache so next get() fetches fresh from DB
        $this->items = collect([]);
    }

    public function get(): Collection
    {

        if (!$this->items->count()) {
            $this->items = Cart::with('product')->where('status', 0)->get();
        }
        return $this->items;
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)->update(['status' => 1]);
        $this->items = collect([]);
    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)->update(['quantity' => $quantity]);
        $this->items = collect([]);
    }

    public function empty()
    {
        // Cart::query()->delete();
        Cart::query()->update(['status' => 1]);
    }

    /* السعر قبل الخصم */

    public function totalBeforeDiscount(): float
    {
        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->discount_price ?? $item->product->price;
        });
    }

    /* السعر بعد الخصم لو فيه خصم*/    /* السعر بعد الخصم لو فيه خصم*/
    public function total(): float
    {
        return $this->get()->sum(function ($item) {
//            dd($item->product->discount_price);
            if ($item->product->discount_price) {
                return $item->quantity * ($item->discounted_price ?? $item->product->discount_price);
            } else {

                return $item->quantity * ($item->discounted_price ?? $item->product->price);
            }
        });
    }
}
