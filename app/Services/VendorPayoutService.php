<?php

namespace App\Services;

use App\Models\Company;
use App\Models\VendorEarning;
use App\Models\VendorPayout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VendorPayoutService
{
    /**
     * Generate payout for vendor for a specific period
     */
    public function generatePayout(Company $vendor, Carbon $periodStart, Carbon $periodEnd)
    {
        return DB::transaction(function () use ($vendor, $periodStart, $periodEnd) {
            // Get available earnings for this period
            $earnings = VendorEarning::where('company_id', $vendor->id)
                ->where('status', 'available')
                ->whereHas('order', function ($q) use ($periodStart, $periodEnd) {
                    $q->whereBetween('created_at', [$periodStart, $periodEnd]);
                })
                ->get();

            if ($earnings->isEmpty()) {
                return null;
            }

            $totalAmount = $earnings->sum('item_total');
            $commissionAmount = $earnings->sum('commission_amount');
            $netAmount = $earnings->sum('vendor_amount');

            // Create payout
            $payout = VendorPayout::create([
                'company_id' => $vendor->id,
                'amount' => $totalAmount,
                'commission_amount' => $commissionAmount,
                'net_amount' => $netAmount,
                'status' => 'pending',
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
            ]);

            // Link earnings to payout
            $earnings->each(function ($earning) use ($payout) {
                $earning->update(['payout_id' => $payout->id]);
            });

            return $payout;
        });
    }

    /**
     * Mark payout as paid
     */
    public function markAsPaid(VendorPayout $payout, $adminId, $transactionReference = null)
    {
        return DB::transaction(function () use ($payout, $adminId, $transactionReference) {
            $payout->update([
                'status' => 'paid',
                'paid_at' => now(),
                'processed_by' => $adminId,
                'transaction_reference' => $transactionReference,
            ]);

            // Update earnings status
            $payout->earnings()->update(['status' => 'paid']);

            return $payout;
        });
    }

    /**
     * Get vendor available balance (not yet paid out)
     */
    public function getAvailableBalance(Company $vendor)
    {
        return VendorEarning::where('company_id', $vendor->id)
            ->where('status', 'available')
            ->sum('vendor_amount');
    }

    /**
     * Get vendor pending balance (orders not yet paid)
     */
    public function getPendingBalance(Company $vendor)
    {
        return VendorEarning::where('company_id', $vendor->id)
            ->where('status', 'pending')
            ->sum('vendor_amount');
    }

    /**
     * Get vendor total paid amount
     */
    public function getTotalPaid(Company $vendor)
    {
        return VendorEarning::where('company_id', $vendor->id)
            ->where('status', 'paid')
            ->sum('vendor_amount');
    }

    /**
     * Generate payouts for all vendors for a period
     */
    public function generatePayoutsForAllVendors(Carbon $periodStart, Carbon $periodEnd)
    {
        $vendors = Company::where('is_vendor', true)
            ->where('status', 'active')
            ->get();

        $payouts = [];
        foreach ($vendors as $vendor) {
            $payout = $this->generatePayout($vendor, $periodStart, $periodEnd);
            if ($payout) {
                $payouts[] = $payout;
            }
        }

        return $payouts;
    }
}
