<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use App\Models\VendorReview;
use Illuminate\Database\Seeder;

class VendorReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = Company::where('is_vendor', true)->where('status', 'active')->get();
        
        if ($vendors->isEmpty()) {
            $this->command->warn('⚠️  No active vendors found. Skipping review seeding.');
            return;
        }

        $users = User::limit(10)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('⚠️  No users found. Skipping review seeding.');
            $this->command->info('💡 Tip: Create users first or run: User::factory(10)->create()');
            return;
        }

        $orders = Order::whereNotNull('company_id')->limit(20)->get();
        
        if ($orders->isEmpty()) {
            $this->command->warn('⚠️  No orders found. Skipping review seeding.');
            $this->command->info('💡 Tip: Create some orders first');
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'خدمة ممتازة ومنتجات عالية الجودة. أنصح بالشراء من هذا المتجر',
                'status' => 'approved',
            ],
            [
                'rating' => 4,
                'comment' => 'تجربة جيدة بشكل عام. التوصيل كان سريع',
                'status' => 'approved',
            ],
            [
                'rating' => 5,
                'comment' => 'المنتجات مطابقة للوصف تماماً. شكراً لكم',
                'status' => 'approved',
            ],
            [
                'rating' => 3,
                'comment' => 'المنتج جيد لكن التوصيل تأخر قليلاً',
                'status' => 'approved',
            ],
            [
                'rating' => 5,
                'comment' => 'أفضل متجر تعاملت معه. سأشتري منهم مرة أخرى بالتأكيد',
                'status' => 'approved',
            ],
            [
                'rating' => 4,
                'comment' => 'منتجات جيدة وأسعار مناسبة',
                'status' => 'approved',
            ],
            [
                'rating' => 2,
                'comment' => 'المنتج لم يكن كما توقعت',
                'status' => 'pending',
            ],
            [
                'rating' => 5,
                'comment' => 'ممتاز جداً! التعامل راقي والمنتجات أصلية',
                'status' => 'approved',
            ],
        ];

        $count = 0;
        foreach ($vendors as $vendor) {
            // Create 3-5 reviews per vendor
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                if ($users->isEmpty() || $orders->isEmpty()) break;
                
                $user = $users->random();
                $order = $orders->random();
                $reviewData = $reviews[array_rand($reviews)];

                try {
                    VendorReview::create([
                        'company_id' => $vendor->id,
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'rating' => $reviewData['rating'],
                        'comment' => $reviewData['comment'],
                        'status' => $reviewData['status'],
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    // Skip if duplicate (same vendor, user, order combination)
                    continue;
                }
            }

            // Update vendor rating
            $vendor->updateRating();
        }

        $this->command->info("✅ Created {$count} vendor reviews");
    }
}
