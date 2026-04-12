<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\VendorPayoutService;
use Illuminate\Http\Request;

class VendorManagementController extends Controller
{
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
     * Show vendor details
     */
    public function show(Company $vendor)
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

        return view('dashboard.vendors.show', compact('vendor', 'stats'));
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

        return redirect()->route('dashboard.vendors.index')
            ->with('success', 'تم حذف البائع بنجاح');
    }
}
