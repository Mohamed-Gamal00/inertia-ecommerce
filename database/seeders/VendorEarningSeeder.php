<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Services\MultiVendorOrderService;
use Illuminate\Database\Seeder;

class VendorEarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderService = app(MultiVendorOrderService::class);

        // Create earnings for all paid orders that have a vendor
        $orders = Order::where('payment_status', 'paid')
            ->whereNotNull('company_id')
            ->whereDoesntHave('earnings')
            ->get();

        if ($orders->isEmpty()) {
            $this->command->warn('⚠️  No paid orders with vendors found. Skipping earnings seeding.');
            return;
        }

        $count = 0;
        foreach ($orders as $order) {
            try {
                $orderService->createEarnings($order);
                $count++;
            } catch (\Exception $e) {
                $this->command->error("Failed to create earnings for order #{$order->number}: " . $e->getMessage());
            }
        }

        $this->command->info("✅ Created earnings for {$count} orders");
    }
}
