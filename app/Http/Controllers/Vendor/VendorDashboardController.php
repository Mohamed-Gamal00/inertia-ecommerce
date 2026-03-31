<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorDashboardController extends Controller
{
    /**
     * @return \App\Models\Company
     */
    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    public function index()
    {
        $vendor = $this->vendor();

        $productsCount = Product::where('company_id', $vendor->id)->count();

        $orderItemsQuery = OrderItem::whereHas('product', fn ($q) => $q->where('company_id', $vendor->id));

        $ordersCount  = $orderItemsQuery->distinct('order_id')->count('order_id');
        $totalRevenue = $orderItemsQuery->sum('price');

        // This month revenue
        $monthRevenue = OrderItem::whereHas('product', fn($q) => $q->where('company_id', $vendor->id))
            ->whereHas('order', fn($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year))
            ->sum('price');

        // Pending orders count
        $pendingOrdersCount = Order::visibleToVendorCompany($vendor->id)
            ->whereHas('orderStatus', fn($q) => $q->where('default_status', true))
            ->count();

        // Returns count
        $returnsCount = Order::visibleToVendorCompany($vendor->id)
            ->where('return_order', true)->count();

        // Low stock products (quantity <= 5)
        $lowStockProducts = Product::where('company_id', $vendor->id)
            ->where('status', 'active')
            ->where('quantity', '<=', 5)
            ->where('quantity', '>', 0)
            ->take(5)->get();

        $lowStockCount = $lowStockProducts->count();

        // Top selling products
        $topProducts = OrderItem::whereHas('product', fn($q) => $q->where('company_id', $vendor->id))
            ->select('product_id',
                \DB::raw('SUM(quantity) as total_quantity'),
                \DB::raw('SUM(price) as total_revenue')
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)->get();

        // Order status breakdown
        $orderStatusBreakdown = Order::visibleToVendorCompany($vendor->id)
            ->with('orderStatus')
            ->get()
            ->groupBy(fn($o) => $o->orderStatus?->CurrentNameLang ?? 'غير محدد')
            ->map->count();

        $recentOrders = Order::visibleToVendorCompany($vendor->id)
            ->with(['orderItems.product', 'addresses', 'orderStatus'])
            ->latest()->take(5)->get();

        return view('vendor.dashboard', compact(
            'vendor', 'productsCount', 'ordersCount', 'totalRevenue',
            'monthRevenue', 'pendingOrdersCount', 'returnsCount',
            'lowStockProducts', 'lowStockCount', 'topProducts',
            'orderStatusBreakdown', 'recentOrders'
        ));
    }

    // Products
    public function products()
    {
        $vendor = $this->vendor();
        $products = Product::where('company_id', $vendor->id)
            ->with(['parent', 'images'])
            ->latest()->paginate(15);

        return view('vendor.products.index', compact('products'));
    }

    // Orders
    public function orders()
    {
        $vendor = $this->vendor();
        $orders = Order::visibleToVendorCompany($vendor->id)
            ->with(['orderItems.product', 'addresses', 'orderStatus'])
            ->latest()
            ->paginate(15);

        return view('vendor.orders.index', compact('orders'));
    }

    // Profile
    public function profile()
    {
        return view('vendor.profile', ['vendor' => $this->vendor()]);
    }

    // Customers
    public function customers()
    {
        $vendor = $this->vendor();

        // Get unique users who ordered vendor's products
        $customers = \App\Models\User::whereHas('orders.orderItems.product', fn($q) =>
            $q->where('company_id', $vendor->id)
        )
        ->withCount(['orders as vendor_orders_count' => fn($q) =>
            $q->whereHas('orderItems.product', fn($q2) =>
                $q2->where('company_id', $vendor->id)
            )
        ])
        ->with(['orders' => fn($q) =>
            $q->whereHas('orderItems.product', fn($q2) =>
                $q2->where('company_id', $vendor->id)
            )->latest()->take(1)
        ])
        ->latest()
        ->paginate(20);

        // Total revenue per customer
        $revenueByUser = \App\Models\OrderItem::whereHas('product', fn($q) =>
            $q->where('company_id', $vendor->id)
        )
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->whereNotNull('orders.user_id')
        ->selectRaw('orders.user_id, SUM(order_items.price) as total_spent')
        ->groupBy('orders.user_id')
        ->pluck('total_spent', 'user_id');

        return view('vendor.customers.index', compact('customers', 'revenueByUser'));
    }

    public function profileUpdate(\Illuminate\Http\Request $request)
    {
        $vendor = $this->vendor();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only('name', 'phone', 'description');

        if ($request->hasFile('image')) {
            // Use existing helper if available or standard Store
            $path = $request->file('image')->store('companies', 'public');
            $data['image'] = $path;
        }

        $vendor->update($data);

        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }
}
