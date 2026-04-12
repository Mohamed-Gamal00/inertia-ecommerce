<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MultiVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This is the main seeder for the multi-vendor system.
     * It runs all vendor-related seeders in the correct order.
     */
    public function run(): void
    {
        $this->command->info('🚀 Seeding Multi-Vendor System...');
        $this->command->newLine();

        // Step 1: Create vendors
        $this->command->info('Step 1: Creating vendors...');
        $this->call(VendorSeeder::class);
        $this->command->newLine();

        // Step 2: Create test data (users, products, orders) - Optional
        if ($this->command->confirm('Create test data (users, products, orders)?', true)) {
            $this->command->info('Step 2: Creating test data...');
            $this->call(TestDataSeeder::class);
            $this->command->newLine();
        }

        // Step 3: Create earnings for existing orders
        $this->command->info('Step 3: Creating vendor earnings...');
        $this->call(VendorEarningSeeder::class);
        $this->command->newLine();

        // Step 4: Create vendor reviews
        $this->command->info('Step 4: Creating vendor reviews...');
        $this->call(VendorReviewSeeder::class);
        $this->command->newLine();

        // Step 5: Generate payouts
        $this->command->info('Step 5: Generating vendor payouts...');
        $this->call(VendorPayoutSeeder::class);
        $this->command->newLine();

        // Summary
        $this->command->info('✅ Multi-Vendor System Seeding Complete!');
        $this->command->newLine();
        
        $this->command->info('Test Credentials:');
        $this->command->table(
            ['Type', 'Email', 'Password'],
            [
                ['Vendor', 'electronics@vendor.com', 'password'],
                ['Vendor', 'fashion@vendor.com', 'password'],
                ['Vendor', 'furniture@vendor.com', 'password'],
                ['User', 'ahmed@test.com', 'password'],
                ['User', 'sara@test.com', 'password'],
            ]
        );
        
        $this->command->newLine();
        $this->command->info('Next steps:');
        $this->command->line('  1. Login as vendor: /vendor/login');
        $this->command->line('  2. Visit vendor storefront: /store/modern-electronics');
        $this->command->line('  3. Admin vendor management: /admin/vendors');
        $this->command->line('  4. Admin payouts: /admin/payouts');
    }
}
