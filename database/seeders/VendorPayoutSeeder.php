<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Services\VendorPayoutService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VendorPayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payoutService = app(VendorPayoutService::class);

        $vendors = Company::where('is_vendor', true)
            ->where('status', 'active')
            ->get();

        if ($vendors->isEmpty()) {
            $this->command->warn('⚠️  No active vendors found. Skipping payout seeding.');
            return;
        }

        // Generate payouts for last month
        $periodStart = Carbon::now()->subMonth()->startOfMonth();
        $periodEnd = Carbon::now()->subMonth()->endOfMonth();

        $count = 0;
        foreach ($vendors as $vendor) {
            try {
                $payout = $payoutService->generatePayout($vendor, $periodStart, $periodEnd);
                
                if ($payout) {
                    $count++;
                    
                    // Randomly mark some as paid (for demo purposes)
                    if (rand(0, 1)) {
                        $payoutService->markAsPaid($payout, 1, 'TXN-' . strtoupper(uniqid()));
                    }
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to create payout for vendor {$vendor->name}: " . $e->getMessage());
            }
        }

        $this->command->info("✅ Created {$count} payouts for period: {$periodStart->format('Y-m-d')} to {$periodEnd->format('Y-m-d')}");
    }
}
