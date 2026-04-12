<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Order;
use App\Services\MultiVendorOrderService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetupMultiVendorSystem extends Command
{
    protected $signature = 'multivendor:setup {--force : Force setup even if data exists}';
    
    protected $description = 'Setup multi-vendor system: update vendors and create earnings for existing orders';

    public function handle(MultiVendorOrderService $orderService)
    {
        $this->info('🚀 Setting up Multi-Vendor System...');
        $this->newLine();

        // Step 1: Update existing vendors
        $this->info('Step 1: Updating existing vendors...');
        $vendorCount = 0;
        
        Company::where('is_vendor', true)->each(function($vendor) use (&$vendorCount) {
            $updates = [];
            
            // Generate store slug if missing
            if (empty($vendor->store_slug)) {
                $slug = Str::slug($vendor->name);
                $count = 1;
                while (Company::where('store_slug', $slug)->where('id', '!=', $vendor->id)->exists()) {
                    $slug = Str::slug($vendor->name) . '-' . $count;
                    $count++;
                }
                $updates['store_slug'] = $slug;
            }
            
            // Set default commission rate if missing
            if (is_null($vendor->commission_rate)) {
                $updates['commission_rate'] = 10.00;
            }
            
            // Set default banner color if missing
            if (empty($vendor->banner_color)) {
                $updates['banner_color'] = '#3490dc';
            }
            
            if (!empty($updates)) {
                $vendor->update($updates);
                $this->line("  ✓ Updated vendor: {$vendor->name}");
                $vendorCount++;
            }
        });
        
        $this->info("  ✅ Updated {$vendorCount} vendors");
        $this->newLine();

        // Step 2: Create earnings for existing paid orders
        $this->info('Step 2: Creating earnings for existing orders...');
        $earningsCount = 0;
        
        Order::where('payment_status', 'paid')
            ->whereNotNull('company_id')
            ->whereDoesntHave('earnings')
            ->each(function($order) use ($orderService, &$earningsCount) {
                try {
                    $orderService->createEarnings($order);
                    $this->line("  ✓ Created earnings for order #{$order->number}");
                    $earningsCount++;
                } catch (\Exception $e) {
                    $this->error("  ✗ Failed for order #{$order->number}: " . $e->getMessage());
                }
            });
        
        $this->info("  ✅ Created earnings for {$earningsCount} orders");
        $this->newLine();

        // Step 3: Update vendor stats
        $this->info('Step 3: Updating vendor statistics...');
        $statsCount = 0;
        
        Company::where('is_vendor', true)->each(function($vendor) use (&$statsCount) {
            $vendor->updateStats();
            $statsCount++;
        });
        
        $this->info("  ✅ Updated stats for {$statsCount} vendors");
        $this->newLine();

        // Summary
        $this->info('✅ Multi-Vendor System Setup Complete!');
        $this->newLine();
        $this->table(
            ['Metric', 'Count'],
            [
                ['Vendors Updated', $vendorCount],
                ['Earnings Created', $earningsCount],
                ['Stats Updated', $statsCount],
            ]
        );
        
        $this->newLine();
        $this->info('Next steps:');
        $this->line('  1. Review vendor store slugs: php artisan tinker → Company::where("is_vendor", true)->pluck("store_slug", "name")');
        $this->line('  2. Test vendor storefront: Visit /store/{slug}');
        $this->line('  3. Generate payouts: Visit /admin/payouts and click "Generate Payouts"');
        
        return Command::SUCCESS;
    }
}
