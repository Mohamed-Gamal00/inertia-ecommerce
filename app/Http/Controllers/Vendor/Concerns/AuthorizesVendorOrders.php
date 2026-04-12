<?php

namespace App\Http\Controllers\Vendor\Concerns;

use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

trait AuthorizesVendorOrders
{
    protected function vendorUser(): Company
    {
        return Auth::guard('vendor')->user();
    }

    protected function ensureVendorSeesOrder(Order $order, ?Company $vendor = null): void
    {
        $vendor = $vendor ?? $this->vendorUser();

        $hasLine = $order->orderItems()
            ->whereHas('product', fn ($q) => $q->where('company_id', $vendor->id))
            ->exists();

        if (! $hasLine) {
            abort(404);
        }
    }

    protected function vendorMayFulfillOrder(Order $order, ?Company $vendor = null): bool
    {
        $vendor = $vendor ?? $this->vendorUser();

        if ($order->company_id) {
            return (int) $order->company_id === (int) $vendor->id;
        }

        $companyIds = $order->orderItems->pluck('product.company_id')->filter()->unique()->values();

        return $companyIds->count() === 1 && (int) $companyIds->first() === (int) $vendor->id;
    }
}
