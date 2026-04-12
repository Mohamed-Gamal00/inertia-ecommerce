<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\VendorPayoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorReportController extends Controller
{
    public function __construct(
        protected VendorPayoutService $payoutService
    ) {}

    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    public function index(Request $request)
    {
        $vendorId = $this->vendor()->id;
        $vendor = $this->vendor();
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
            'available_balance' => $this->payoutService->getAvailableBalance($vendor),
            'pending_balance' => $this->payoutService->getPendingBalance($vendor),
            'total_paid' => $this->payoutService->getTotalPaid($vendor),
            'commission_paid' => $vendor->earnings()->where('status', 'paid')->sum('commission_amount'),
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

        // Customer analytics
        $topCustomers = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereHas('product', function($q) use ($vendorId) {
                $q->where('company_id', $vendorId);
            })
            ->where('orders.payment_status', 'paid')
            ->select('users.id', 'users.first_name', 'users.family_name', 
                DB::raw('COUNT(DISTINCT orders.id) as order_count'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_spent'))
            ->groupBy('users.id', 'users.first_name', 'users.family_name')
            ->orderByDesc('total_spent')
            ->take(10)
            ->get();

        return view('vendor.reports.index', compact('stats', 'topProducts', 'salesOverTime', 'topCustomers', 'start_date', 'end_date'));
    }

    /**
     * Export report to CSV
     */
    public function export(Request $request)
    {
        $vendorId = $this->vendor()->id;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereHas('product', function($q) use ($vendorId) {
                $q->where('company_id', $vendorId);
            })
            ->where('orders.payment_status', 'paid')
            ->select('orders.number', 'orders.created_at', 'order_items.product_name', 
                'order_items.quantity', 'order_items.price',
                DB::raw('order_items.price * order_items.quantity as total'));

        if ($start_date && $end_date) {
            $query->whereBetween('orders.created_at', [$start_date, $end_date]);
        }

        $data = $query->get();

        $filename = 'vendor_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Order Number', 'Date', 'Product', 'Quantity', 'Price', 'Total']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->number,
                    $row->created_at->format('Y-m-d H:i'),
                    $row->product_name,
                    $row->quantity,
                    $row->price,
                    $row->total,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
