<?php

namespace App\Http\Controllers\Inertia;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnProductsController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $returnOrders = $user->orders()
            ->with('orderItems')
            ->where('return_order', true)
            ->latest()
            ->get();

        return response()->json($returnOrders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'return_order_id' => 'required|exists:orders,id',
        ]);

        $user  = Auth::guard('web')->user();
        $order = Order::where('id', $request->return_order_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $order->update([
            'return_order' => true,
            'status'       => OrderStatus::Pending,
        ]);

        return response()->json(['message' => __('flash.return_request_success')]);
    }
}
