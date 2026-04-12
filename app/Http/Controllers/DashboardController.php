<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Counts ──
        $productsCount  = Product::count();
        $ordersCount    = Order::where('return_order', false)->count();
        $usersCount     = User::count();
        $messagesCount  = ContactUs::count();
        $adminsCount    = \App\Models\Admin::count();
        $returnsCount   = Order::where('return_order', true)->count();

        // ── Revenue ──
        $totalRevenue   = Order::where('return_order', false)
                            ->where('payment_status', 'paid')
                            ->sum('total_price');

        $todayRevenue   = Order::where('return_order', false)
                            ->where('payment_status', 'paid')
                            ->whereDate('created_at', today())
                            ->sum('total_price');

        // ── Orders this month vs last month ──
        $thisMonthOrders = Order::where('return_order', false)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        $lastMonthOrders = Order::where('return_order', false)
                            ->whereMonth('created_at', now()->subMonth()->month)
                            ->whereYear('created_at', now()->subMonth()->year)
                            ->count();

        // ── Orders by status (last 30 days) ──
        $ordersByStatus = Order::where('return_order', false)
                            ->where('created_at', '>=', now()->subDays(30))
                            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
                            ->select('order_statuses.name', DB::raw('count(*) as total'))
                            ->groupBy('order_statuses.name')
                            ->get();

        // ── Sales last 7 days ──
        $salesLast7Days = Order::where('return_order', false)
                            ->where('payment_status', 'paid')
                            ->where('created_at', '>=', now()->subDays(6))
                            ->select(
                                DB::raw('DATE(created_at) as date'),
                                DB::raw('SUM(total_price) as total'),
                                DB::raw('COUNT(*) as count')
                            )
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get()
                            ->keyBy('date');

        // Fill missing days
        $salesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $salesChart[] = [
                'label' => $label,
                'total' => (float) ($salesLast7Days[$date]->total ?? 0),
                'count' => (int)   ($salesLast7Days[$date]->count ?? 0),
            ];
        }

        // ── Latest 5 orders ──
        $latestOrders = Order::with(['user', 'orderStatus'])
                            ->where('return_order', false)
                            ->latest()
                            ->take(5)
                            ->get();

        // ── Low stock products ──
        $lowStockProducts = Product::where('quantity', '<=', 5)
                            ->where('quantity', '>', 0)
                            ->orderBy('quantity')
                            ->take(5)
                            ->get();

        // ── Out of stock ──
        $outOfStockCount = Product::where('quantity', 0)->count();

        // ── Top selling products ──
        $topProducts = DB::table('order_items')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->select('products.name', DB::raw('SUM(order_items.quantity) as sold'))
                        ->groupBy('products.id', 'products.name')
                        ->orderByDesc('sold')
                        ->take(5)
                        ->get();

        // ── Currency ──
        $mainCurrency = DB::table('currencies')->where('default_currency', true)->first();

        // ── Pending orders ──
        $pendingOrders = Order::where('return_order', false)
                            ->whereHas('orderStatus', fn($q) => $q->where('default_status', true))
                            ->count();

        return view('dashboard.dashboard', compact(
            'productsCount', 'ordersCount', 'usersCount', 'messagesCount',
            'adminsCount', 'returnsCount', 'totalRevenue', 'todayRevenue',
            'thisMonthOrders', 'lastMonthOrders', 'ordersByStatus',
            'salesChart', 'latestOrders', 'lowStockProducts',
            'outOfStockCount', 'topProducts', 'mainCurrency', 'pendingOrders'
        ));
    }
}
