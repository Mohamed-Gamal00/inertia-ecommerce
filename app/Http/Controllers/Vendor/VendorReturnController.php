<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class VendorReturnController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();

        $orders = Order::visibleToVendorCompany($vendor->id)
            ->where('return_order', true)
            ->with(['orderItems.product', 'addresses', 'orderStatus'])
            ->latest()
            ->paginate(15);

        return view('vendor.returns.index', compact('orders'));
    }
}
