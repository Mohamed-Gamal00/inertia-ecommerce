<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\VendorPayout;
use App\Services\VendorPayoutService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorPayoutController extends Controller
{
    public function __construct(
        protected VendorPayoutService $payoutService
    ) {}

    /**
     * List all payouts
     */
    public function index(Request $request)
    {
        $query = VendorPayout::with('company');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('vendor_id')) {
            $query->where('company_id', $request->vendor_id);
        }

        $payouts = $query->latest()->paginate(20);
        $vendors = Company::where('is_vendor', true)->get();

        return view('dashboard.payouts.index', compact('payouts', 'vendors'));
    }

    /**
     * Show payout details
     */
    public function show(VendorPayout $payout)
    {
        $payout->load(['company', 'earnings.orderItem.product', 'processedBy']);

        return view('dashboard.payouts.show', compact('payout'));
    }

    /**
     * Generate payouts for period
     */
    public function generate(Request $request)
    {
        $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'vendor_id' => 'nullable|exists:companies,id',
        ]);

        $periodStart = Carbon::parse($request->period_start);
        $periodEnd = Carbon::parse($request->period_end);

        if ($request->vendor_id) {
            $vendor = Company::findOrFail($request->vendor_id);
            $payout = $this->payoutService->generatePayout($vendor, $periodStart, $periodEnd);
            
            if (!$payout) {
                return back()->with('error', 'لا توجد أرباح متاحة للبائع في هذه الفترة');
            }

            return redirect()->route('dashboard.payouts.show', $payout)
                ->with('success', 'تم إنشاء المستحقات بنجاح');
        }

        // Generate for all vendors
        $payouts = $this->payoutService->generatePayoutsForAllVendors($periodStart, $periodEnd);

        return back()->with('success', 'تم إنشاء ' . count($payouts) . ' مستحقات للبائعين');
    }

    /**
     * Mark payout as paid
     */
    public function markAsPaid(Request $request, VendorPayout $payout)
    {
        $request->validate([
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($payout->status === 'paid') {
            return back()->with('error', 'المستحقات مدفوعة بالفعل');
        }

        $this->payoutService->markAsPaid(
            $payout,
            Auth::guard('admin')->id(),
            $request->transaction_reference
        );

        if ($request->notes) {
            $payout->update(['notes' => $request->notes]);
        }

        return back()->with('success', 'تم تحديث حالة الدفع بنجاح');
    }

    /**
     * Update payout status
     */
    public function updateStatus(Request $request, VendorPayout $payout)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,paid,failed',
        ]);

        $payout->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث الحالة بنجاح');
    }
}
