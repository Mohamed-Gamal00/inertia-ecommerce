<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorReportController extends Controller
{
    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    public function index(Request $request)
    {
        $vendorId = $this->vendor()->id;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Base query for order items belonging to this vendor
        $query = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereHas('product', function($q) use ($vendorId) {
                $q->where('company_id', $vendorId);
            })->where('orders.payment_status', 'paid');

        if ($start_date && $end_date) {
            $query->whereBetween('orders.created_at', [$start_date, $end_date]);
        }

        // Stats
        $stats = [
            'total_revenue' => $query->sum(DB::raw('order_items.price * order_items.quantity')),
            'total_orders' => $query->distinct('order_items.order_id')->count('order_items.order_id'),
            'total_items_sold' => $query->sum('order_items.quantity'),
        ];

        // Top Products
        $topProducts = OrderItem::whereHas('product', function($q) use ($vendorId) {
            $q->where('company_id', $vendorId);
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(price * quantity) as total_revenue'))
        ->with('product')
        ->groupBy('product_id')
        ->orderByDesc('total_quantity')
        ->take(5)
        ->get();

        // Sales over time (last 30 days)
        $salesOverTime = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        ->whereHas('product', function($q) use ($vendorId) {
            $q->where('company_id', $vendorId);
        })
        ->select(DB::raw('DATE(orders.created_at) as date'), DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
        ->where('orders.payment_status', 'paid')
        ->where('orders.created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return view('vendor.reports.index', compact('stats', 'topProducts', 'salesOverTime', 'start_date', 'end_date'));
    }
}
