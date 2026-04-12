<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Seed test data for multi-vendor system testing.
     * Creates users, assigns products to vendors, and creates sample orders.
     */
    public function run(): void
    {
        $this->command->info('🧪 Creating test data for multi-vendor system...');
        $this->command->newLine();

        // Step 1: Create test users
        $this->command->info('Step 1: Creating test users...');
        $users = $this->createUsers();
        $this->command->info("✅ Created {$users->count()} users");
        $this->command->newLine();

        // Step 2: Assign products to vendors
        $this->command->info('Step 2: Assigning products to vendors...');
        $productsAssigned = $this->assignProductsToVendors();
        $this->command->info("✅ Assigned {$productsAssigned} products to vendors");
        $this->command->newLine();

        // Step 3: Create sample orders
        $this->command->info('Step 3: Creating sample orders...');
        $ordersCreated = $this->createSampleOrders($users);
        $this->command->info("✅ Created {$ordersCreated} orders");
        $this->command->newLine();

        $this->command->info('✅ Test data creation complete!');
        $this->command->newLine();
        
        $this->command->info('Test Users:');
        $this->command->table(
            ['Name', 'Email', 'Password'],
            [
                ['Ahmed Ali', 'ahmed@test.com', 'password'],
                ['Sara Mohammed', 'sara@test.com', 'password'],
                ['Khalid Hassan', 'khalid@test.com', 'password'],
            ]
        );
    }

    protected function createUsers()
    {
        $testUsers = [
            [
                'first_name' => 'Ahmed',
                'family_name' => 'Ali',
                'email' => 'ahmed@test.com',
                'password' => Hash::make('password'),
                'phone_number' => '0501111111',
            ],
            [
                'first_name' => 'Sara',
                'family_name' => 'Mohammed',
                'email' => 'sara@test.com',
                'password' => Hash::make('password'),
                'phone_number' => '0502222222',
            ],
            [
                'first_name' => 'Khalid',
                'family_name' => 'Hassan',
                'email' => 'khalid@test.com',
                'password' => Hash::make('password'),
                'phone_number' => '0503333333',
            ],
        ];

        $users = collect();
        foreach ($testUsers as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            $users->push($user);
        }

        return $users;
    }

    protected function assignProductsToVendors()
    {
        $vendors = Company::where('is_vendor', true)->where('status', 'active')->get();
        
        if ($vendors->isEmpty()) {
            $this->command->warn('⚠️  No active vendors found. Run VendorSeeder first.');
            return 0;
        }

        $products = Product::whereNull('company_id')->orWhere('company_id', 0)->limit(20)->get();
        
        if ($products->isEmpty()) {
            $this->command->warn('⚠️  No products found. Create products first.');
            return 0;
        }

        $count = 0;
        foreach ($products as $product) {
            $vendor = $vendors->random();
            $product->update(['company_id' => $vendor->id]);
            $count++;
        }

        return $count;
    }

    protected function createSampleOrders($users)
    {
        $vendors = Company::where('is_vendor', true)->where('status', 'active')->get();
        
        if ($vendors->isEmpty() || $users->isEmpty()) {
            $this->command->warn('⚠️  No vendors or users found.');
            return 0;
        }

        $products = Product::whereNotNull('company_id')->get();
        
        if ($products->isEmpty()) {
            $this->command->warn('⚠️  No products assigned to vendors.');
            return 0;
        }

        $count = 0;
        
        // Create 5 sample orders
        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $vendor = $vendors->random();
            $vendorProducts = $products->where('company_id', $vendor->id);
            
            if ($vendorProducts->isEmpty()) {
                continue;
            }

            $product = $vendorProducts->random();
            
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'company_id' => $vendor->id,
                'payment_status' => rand(0, 1) ? 'paid' : 'pending',
                'payment_method' => 'creditcard',
                'status' => 'completed',
                'order_status_id' => 1,
                'total_price' => $product->price * 2,
                'totalBeforeDiscount' => $product->price * 2,
                'shipping_price' => 0,
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => 2,
            ]);

            $count++;
        }

        return $count;
    }
}
