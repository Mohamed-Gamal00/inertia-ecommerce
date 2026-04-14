<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\VendorEarning;
use App\Services\Vendor\VendorOrderNotificationService;
use Illuminate\Support\Facades\DB;

class MultiVendorOrderService
{
    /**
     * Split cart items by vendor and create parent + sub-orders
     */
    public function createMultiVendorOrder(array $orderData, $cartItems)
    {
        return DB::transaction(function () use ($orderData, $cartItems) {
            // Group cart items by vendor
            $itemsByVendor = $this->groupItemsByVendor($cartItems);

            // If single vendor, create normal order
            if (count($itemsByVendor) === 1) {
                return $this->createSingleVendorOrder($orderData, $cartItems, array_key_first($itemsByVendor));
            }

            // Multi-vendor: create parent order
            $parentOrder = $this->createParentOrder($orderData);

            // Create sub-orders for each vendor
            $subOrders = [];
            foreach ($itemsByVendor as $vendorId => $items) {
                $subOrder = $this->createSubOrder($parentOrder, $orderData, $items, $vendorId);
                $subOrders[] = $subOrder;

                // Notify vendor of new order
                $this->notifyVendor($subOrder);
            }

            return [
                'parent_order' => $parentOrder,
                'sub_orders' => $subOrders,
            ];
        });
    }

    /**
     * Group cart items by vendor (company_id)
     */
    protected function groupItemsByVendor($cartItems)
    {
        $grouped = [];
        foreach ($cartItems as $item) {
            $vendorId = $item->product->company_id ?? 0;
            if (!isset($grouped[$vendorId])) {
                $grouped[$vendorId] = [];
            }
            $grouped[$vendorId][] = $item;
        }
        return $grouped;
    }

    /**
     * Create single vendor order (no splitting needed)
     */
    protected function createSingleVendorOrder(array $orderData, $cartItems, $vendorId)
    {
        $orderData['company_id'] = $vendorId;
        $orderData['is_parent'] = false;

        $order = Order::create($orderData);

        $this->attachOrderItems($order, $cartItems);
        $this->createEarnings($order);

        // Notify vendor of new order
        $this->notifyVendor($order);

        return $order;
    }

    /**
     * Create parent order (holds total, customer info)
     */
    protected function createParentOrder(array $orderData)
    {
        $orderData['is_parent'] = true;
        $orderData['company_id'] = null; // Parent has no specific vendor

        return Order::create($orderData);
    }

    /**
     * Create sub-order for specific vendor
     */
    protected function createSubOrder(Order $parentOrder, array $orderData, $items, $vendorId)
    {
        // Calculate sub-order total
        $subTotal = 0;
        foreach ($items as $item) {
            $price = $item->discounted_price ?? $item->product->discount_price ?? $item->product->price;
            $subTotal += $price * $item->quantity;
        }

        $subOrderData = [
            'parent_order_id' => $parentOrder->id,
            'company_id' => $vendorId,
            'is_parent' => false,
            'user_id' => $orderData['user_id'] ?? null,
            'guest_id' => $orderData['guest_id'] ?? null,
            'cookie_id' => $orderData['cookie_id'] ?? null,
            'payment_method' => $orderData['payment_method'] ?? null,
            'payment_status' => $orderData['payment_status'] ?? 'pending',
            'order_status_id' => $orderData['order_status_id'] ?? null,
            'total_price' => $subTotal,
            'totalBeforeDiscount' => $subTotal,
            'shipping_price' => 0, // Can be calculated per vendor
        ];

        $subOrder = Order::create($subOrderData);

        $this->attachOrderItems($subOrder, $items);
        $this->createEarnings($subOrder);

        return $subOrder;
    }

    /**
     * Attach cart items to order as order_items
     */
    protected function attachOrderItems(Order $order, $cartItems)
    {
        foreach ($cartItems as $item) {
            // Use discounted price if available, otherwise use product price
            $price = $item->discounted_price ?? $item->product->discount_price ?? $item->product->price;

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $price,
                'quantity' => $item->quantity,
            ]);

            // Attach choices if any
            if ($item->choices && $item->choices->count() > 0) {
                foreach ($item->choices as $choice) {
                    $orderItem->choices()->attach($choice->id, [
                        'sub_choice_id' => $choice->pivot->sub_choice_id ?? null,
                    ]);
                }
            }

            // Decrement product quantity
            $item->product->decrement('quantity', $item->quantity);
        }
    }

    /**
     * Create vendor earnings records for order
     */
    public function createEarnings(Order $order)
    {
        if (!$order->company_id) return; // Skip parent orders

        $vendor = $order->company;
        if (!$vendor) return;

        foreach ($order->orderItems as $item) {
            $itemTotal = $item->price * $item->quantity;
            $commissionRate = $vendor->commission_rate ?? 10;
            $commissionAmount = ($itemTotal * $commissionRate) / 100;
            $vendorAmount = $itemTotal - $commissionAmount;

            VendorEarning::create([
                'company_id' => $order->company_id,
                'order_id' => $order->id,
                'order_item_id' => $item->id,
                'item_total' => $itemTotal,
                'commission_amount' => $commissionAmount,
                'vendor_amount' => $vendorAmount,
                'commission_rate' => $commissionRate,
                'status' => $order->payment_status === 'paid' ? 'available' : 'pending',
            ]);
        }
    }

    /**
     * Update earnings status when order payment status changes
     */
    public function updateEarningsStatus(Order $order, string $newStatus)
    {
        $earningStatus = match($newStatus) {
            'paid' => 'available',
            'refunded', 'cancelled' => 'cancelled',
            default => 'pending',
        };

        $order->earnings()->update(['status' => $earningStatus]);
    }

    /**
     * Notify vendor of new order
     */
    protected function notifyVendor(Order $order)
    {
        if (!$order->company_id || !$order->company) {
            return; // Skip if no vendor assigned
        }

        try {
            // Use existing vendor notification service
            VendorOrderNotificationService::notifyNewOrder($order);
        } catch (\Exception $e) {
            // Log error but don't fail the order creation
            \Log::error('Failed to notify vendor of new order', [
                'order_id' => $order->id,
                'vendor_id' => $order->company_id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
