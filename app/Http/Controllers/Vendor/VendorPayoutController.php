<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\VendorPayoutService;
use Illuminate\Support\Facades\Auth;

class VendorPayoutController extends Controller
{
    public function __construct(
        protected VendorPayoutService $payoutService
    ) {}

    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    /**
     * Show vendor payouts and earnings
     */
    public function index()
    {
        $vendor = $this->vendor();

        $payouts = $vendor->payouts()
            ->with('processedBy')
            ->latest()
            ->paginate(15);

        $stats = [
            'available_balance' => $this->payoutService->getAvailableBalance($vendor),
            'pending_balance' => $this->payoutService->getPendingBalance($vendor),
            'total_paid' => $this->payoutService->getTotalPaid($vendor),
            'total_earnings' => $vendor->earnings()->sum('vendor_amount'),
            'total_commission' => $vendor->earnings()->sum('commission_amount'),
        ];

        return view('vendor.payouts.index', compact('payouts', 'stats'));
    }

    /**
     * Show payout details
     */
    public function show($id)
    {
        $vendor = $this->vendor();
        
        $payout = $vendor->payouts()
            ->with(['earnings.orderItem.product', 'earnings.order'])
            ->findOrFail($id);

        return view('vendor.payouts.show', compact('payout'));
    }

    /**
     * Show earnings history
     */
    public function earnings()
    {
        $vendor = $this->vendor();

        $earnings = $vendor->earnings()
            ->with(['order', 'orderItem.product', 'payout'])
            ->latest()
            ->paginate(20);

        return view('vendor.payouts.earnings', compact('earnings'));
    }
}
