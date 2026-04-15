<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Vendor\VendorRequest;
use App\Models\Company;
use App\Services\VendorPayoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class VendorManagementController extends Controller
{
    use Helper;

    public function __construct(
        protected VendorPayoutService $payoutService
    ) {}

    /**
     * List all vendors
     */
    public function index(Request $request)
    {
        $query = Company::where('is_vendor', true);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $vendors = $query->withCount('products')
            ->latest()
            ->paginate(20);

        return view('dashboard.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new vendor
     */
    public function create()
    {
        return view('dashboard.vendors.create');
    }

    /**
     * Store a newly created vendor
     */
    public function store(VendorRequest $request)
    {
        $data = $request->validated();

        // Handle image uploads
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadedImage($request, 'image', 'vendors');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->uploadedImage($request, 'cover_image', 'vendors');
        }

        // Hash password
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Set vendor flag
        $data['is_vendor'] = true;

        // Create vendor
        $vendor = Company::create($data);

        return redirect()->route('vendors.index')
            ->with('success', 'تم إنشاء البائع بنجاح');
    }

    /**
     * Show vendor details
     */
    public function show(Company $vendor, Request $request)
    {
        $vendor->load(['products', 'payouts', 'reviews']);

        $stats = [
            'total_products' => $vendor->products()->count(),
            'active_products' => $vendor->products()->where('status', 'active')->count(),
            'total_orders' => $vendor->earnings()->distinct('order_id')->count('order_id'),
            'total_revenue' => $vendor->earnings()->sum('item_total'),
            'total_commission' => $vendor->earnings()->sum('commission_amount'),
            'available_balance' => $this->payoutService->getAvailableBalance($vendor),
            'pending_balance' => $this->payoutService->getPendingBalance($vendor),
            'total_paid' => $this->payoutService->getTotalPaid($vendor),
        ];

        // Get orders for this vendor
        $ordersQuery = \App\Models\Order::query()
            ->where(function ($q) use ($vendor) {
                // Orders directly assigned to this vendor
                $q->where('company_id', $vendor->id)
                  // Or orders containing products from this vendor
                  ->orWhereHas('orderItems.product', function ($productQuery) use ($vendor) {
                      $productQuery->where('company_id', $vendor->id);
                  });
            })
            ->with([
                'user',
                'guest',
                'orderItems.product',
                'orderStatus',
                'addresses' => function ($q) {
                    $q->where('type', 'billing');
                }
            ])
            ->latest();

        // Filter by status if provided
        if ($request->filled('order_status')) {
            $ordersQuery->where('status', $request->order_status);
        }

        // Filter by order number if provided
        if ($request->filled('order_search')) {
            $ordersQuery->where('number', 'like', '%' . $request->order_search . '%');
        }

        $orders = $ordersQuery->paginate(10)->appends(request()->query());

        // Get order status counts for this vendor
        $orderStatusCounts = [
            'all' => \App\Models\Order::where(function ($q) use ($vendor) {
                $q->where('company_id', $vendor->id)
                  ->orWhereHas('orderItems.product', function ($productQuery) use ($vendor) {
                      $productQuery->where('company_id', $vendor->id);
                  });
            })->count(),
            'pending' => \App\Models\Order::where(function ($q) use ($vendor) {
                $q->where('company_id', $vendor->id)
                  ->orWhereHas('orderItems.product', function ($productQuery) use ($vendor) {
                      $productQuery->where('company_id', $vendor->id);
                  });
            })->where('status', 'pending')->count(),
            'processing' => \App\Models\Order::where(function ($q) use ($vendor) {
                $q->where('company_id', $vendor->id)
                  ->orWhereHas('orderItems.product', function ($productQuery) use ($vendor) {
                      $productQuery->where('company_id', $vendor->id);
                  });
            })->where('status', 'processing')->count(),
            'completed' => \App\Models\Order::where(function ($q) use ($vendor) {
                $q->where('company_id', $vendor->id)
                  ->orWhereHas('orderItems.product', function ($productQuery) use ($vendor) {
                      $productQuery->where('company_id', $vendor->id);
                  });
            })->where('status', 'completed')->count(),
        ];

        return view('dashboard.vendors.show', compact('vendor', 'stats', 'orders', 'orderStatusCounts'));
    }

    /**
     * Show the form for editing the specified vendor
     */
    public function edit(Company $vendor)
    {
        return view('dashboard.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor
     */
    public function update(VendorRequest $request, Company $vendor)
    {
        $data = $request->validated();

        // Handle image uploads
        if ($request->hasFile('image')) {
            // Delete old image
            if ($vendor->image) {
                Storage::disk('public')->delete($vendor->image);
            }
            $data['image'] = $this->uploadedImage($request, 'image', 'vendors');
        }

        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($vendor->cover_image) {
                Storage::disk('public')->delete($vendor->cover_image);
            }
            $data['cover_image'] = $this->uploadedImage($request, 'cover_image', 'vendors');
        }

        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Update vendor
        $vendor->update($data);

        return redirect()->route('vendors.index')
            ->with('success', 'تم تحديث البائع بنجاح');
    }

    /**
     * Update vendor status
     */
    public function updateStatus(Request $request, Company $vendor)
    {
        $request->validate([
            'status' => 'required|in:active,pending,suspended',
        ]);

        $vendor->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة البائع بنجاح');
    }

    /**
     * Approve vendor (set status to active)
     */
    public function approve(Company $vendor)
    {
        $vendor->update(['status' => 'active']);

        return back()->with('success', 'تم تفعيل البائع بنجاح');
    }

    /**
     * Suspend vendor (set status to suspended)
     */
    public function suspend(Company $vendor)
    {
        $vendor->update(['status' => 'suspended']);

        return back()->with('success', 'تم إيقاف البائع بنجاح');
    }

    /**
     * Update vendor commission rate
     */
    public function updateCommission(Request $request, Company $vendor)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        $vendor->update(['commission_rate' => $request->commission_rate]);

        return back()->with('success', 'تم تحديث نسبة العمولة بنجاح');
    }

    /**
     * Delete vendor
     */
    public function destroy(Company $vendor)
    {
        // Check if vendor has orders
        if ($vendor->earnings()->exists()) {
            return back()->with('error', 'لا يمكن حذف البائع لوجود طلبات مرتبطة به');
        }

        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', 'تم حذف البائع بنجاح');
    }
}
