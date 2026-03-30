<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\Concerns\AuthorizesVendorOrders;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    use AuthorizesVendorOrders;

    public function show(Order $order)
    {
        $vendor = Auth::guard('vendor')->user();
        $this->ensureVendorSeesOrder($order, $vendor);

        $order->load([
            'orderItems.product.parent',
            'addresses.country',
            'addresses.city',
            'orderStatus',
        ]);

        $vendorItems = $order->orderItems->filter(fn ($item) => $item->product && (int) $item->product->company_id === (int) $vendor->id
        );

        $orderStatuses = OrderStatus::orderBy('arrangement')->get();
        $canUpdateStatus = $this->vendorMayFulfillOrder($order, $vendor);

        return view('vendor.orders.show', compact(
            'order',
            'vendorItems',
            'orderStatuses',
            'canUpdateStatus'
        ));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $vendor = Auth::guard('vendor')->user();
        $this->ensureVendorSeesOrder($order, $vendor);

        $order->load('orderItems.product');
        if (! $this->vendorMayFulfillOrder($order, $vendor)) {
            abort(403, 'لا يمكنك تعديل حالة هذا الطلب (طلب مشترك أو غير مرتبط بمتجرك بالكامل).');
        }

        $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id',
        ]);

        $order->update([
            'order_status_id' => $request->order_status_id,
        ]);

        return back()->with('success', 'تم تحديث حالة الطلب.');
    }
}
