<?php

namespace App\Services\Vendor;

use App\Models\Company;
use App\Models\Order;
use App\Notifications\NewOrderForVendorNotification;
use App\Notifications\ReturnRequestedForVendorNotification;

class VendorOrderNotificationService
{
    public static function notifyNewOrder(Order $order): void
    {
        $company = self::resolveNotifiableVendorCompany($order);
        if ($company) {
            $company->notify(new NewOrderForVendorNotification($order));
        }
    }

    public static function notifyReturnRequested(Order $order): void
    {
        $company = self::resolveNotifiableVendorCompany($order);
        if ($company) {
            $company->notify(new ReturnRequestedForVendorNotification($order));
        }
    }

    protected static function resolveNotifiableVendorCompany(Order $order): ?Company
    {
        $order->loadMissing('orderItems.product');

        $companyId = $order->company_id;
        if (! $companyId) {
            $ids = $order->orderItems->pluck('product.company_id')->filter()->unique()->values();
            if ($ids->count() !== 1) {
                return null;
            }
            $companyId = (int) $ids->first();
        }

        return Company::query()
            ->where('id', $companyId)
            ->where('is_vendor', true)
            ->where('status', 'active')
            ->first();
    }
}
