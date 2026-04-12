<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\MultiVendorOrderService;

class OrderObserver
{
    public function __construct(
        protected MultiVendorOrderService $orderService
    ) {}

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Update earnings status when payment status changes
        if ($order->isDirty('payment_status')) {
            $this->orderService->updateEarningsStatus($order, $order->payment_status);
        }
    }
}
