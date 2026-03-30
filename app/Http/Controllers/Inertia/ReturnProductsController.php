<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\Vendor\VendorOrderNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnProductsController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $returnOrders = $user->orders()
            ->with(['orderItems', 'orderStatus'])
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

        $user = Auth::guard('web')->user();
        $order = Order::where('id', $request->return_order_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $statusId = OrderStatus::where('default_status', true)->value('id');

        $wasAlreadyReturn = (bool) $order->return_order;

        $order->update([
            'return_order' => true,
            'order_status_id' => $statusId,
        ]);

        if (! $wasAlreadyReturn) {
            VendorOrderNotificationService::notifyReturnRequested($order->fresh());
        }

        return response()->json(['message' => 'تم تقديم طلب الإرجاع بنجاح']);
    }
}
