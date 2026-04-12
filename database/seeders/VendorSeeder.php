<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'متجر الإلكترونيات الحديثة',
                'name_en' => 'Modern Electronics Store',
                'email' => 'electronics@vendor.com',
                'password' => Hash::make('password'),
                'phone' => '0501234567',
                'description' => 'متخصصون في بيع الأجهزة الإلكترونية والهواتف الذكية',
                'status' => 'active',
                'is_vendor' => true,
                'store_slug' => 'modern-electronics',
                'banner_color' => '#1e40af',
                'commission_rate' => 10.00,
                'social_links' => [
                    'instagram' => 'https://instagram.com/modern_electronics',
                    'twitter' => 'https://twitter.com/modern_electronics',
                    'facebook' => 'https://facebook.com/modern.electronics',
                    'whatsapp' => '966501234567',
                ],
                'return_policy' => 'يمكن إرجاع المنتجات خلال 14 يوم من تاريخ الاستلام في حالة وجود عيب صناعي',
                'shipping_policy' => 'الشحن مجاني للطلبات فوق 500 ريال. التوصيل خلال 3-5 أيام عمل',
                'bank_account' => 'SA1234567890123456789012',
                'bank_name' => 'البنك الأهلي السعودي',
                'business_license' => '1234567890',
                'tax_number' => '300123456789003',
                'rating' => 4.5,
                'total_sales' => 0,
                'total_products' => 0,
            ],
            [
                'name' => 'متجر الأزياء العصرية',
                'name_en' => 'Fashion Trends Store',
                'email' => 'fashion@vendor.com',
                'password' => Hash::make('password'),
                'phone' => '0507654321',
                'description' => 'أحدث صيحات الموضة والأزياء النسائية والرجالية',
                'status' => 'active',
                'is_vendor' => true,
                'store_slug' => 'fashion-trends',
                'banner_color' => '#ec4899',
                'commission_rate' => 12.00,
                'social_links' => [
                    'instagram' => 'https://instagram.com/fashion_trends',
                    'twitter' => 'https://twitter.com/fashion_trends',
                    'facebook' => 'https://facebook.com/fashion.trends',
                    'whatsapp' => '966507654321',
                ],
                'return_policy' => 'يمكن استبدال المنتجات خلال 7 أيام من تاريخ الاستلام',
                'shipping_policy' => 'الشحن مجاني لجميع الطلبات. التوصيل خلال 2-4 أيام عمل',
                'bank_account' => 'SA9876543210987654321098',
                'bank_name' => 'بنك الراجحي',
                'business_license' => '9876543210',
                'tax_number' => '300987654321003',
                'rating' => 4.8,
                'total_sales' => 0,
                'total_products' => 0,
            ],
            [
                'name' => 'متجر الأثاث المنزلي',
                'name_en' => 'Home Furniture Store',
                'email' => 'furniture@vendor.com',
                'password' => Hash::make('password'),
                'phone' => '0509876543',
                'description' => 'أثاث منزلي عصري وكلاسيكي بأفضل الأسعار',
                'status' => 'active',
                'is_vendor' => true,
                'store_slug' => 'home-furniture',
                'banner_color' => '#059669',
                'commission_rate' => 8.00,
                'social_links' => [
                    'instagram' => 'https://instagram.com/home_furniture',
                    'twitter' => 'https://twitter.com/home_furniture',
                    'facebook' => 'https://facebook.com/home.furniture',
                    'whatsapp' => '966509876543',
                ],
                'return_policy' => 'يمكن إرجاع المنتجات خلال 30 يوم في حالة وجود عيب',
                'shipping_policy' => 'الشحن مجاني للطلبات فوق 1000 ريال. التوصيل خلال 5-7 أيام عمل',
                'bank_account' => 'SA5555666677778888999900',
                'bank_name' => 'بنك الرياض',
                'business_license' => '5555666677',
                'tax_number' => '300555666677003',
                'rating' => 4.3,
                'total_sales' => 0,
                'total_products' => 0,
            ],
            [
                'name' => 'متجر الرياضة واللياقة',
                'name_en' => 'Sports & Fitness Store',
                'email' => 'sports@vendor.com',
                'password' => Hash::make('password'),
                'phone' => '0503334444',
                'description' => 'معدات رياضية ومكملات غذائية للرياضيين',
                'status' => 'pending',
                'is_vendor' => true,
                'store_slug' => 'sports-fitness',
                'banner_color' => '#f59e0b',
                'commission_rate' => 15.00,
                'social_links' => [
                    'instagram' => 'https://instagram.com/sports_fitness',
                    'twitter' => 'https://twitter.com/sports_fitness',
                    'whatsapp' => '966503334444',
                ],
                'return_policy' => 'لا يمكن إرجاع المكملات الغذائية بعد فتحها',
                'shipping_policy' => 'الشحن مجاني للطلبات فوق 300 ريال',
                'bank_account' => 'SA3333444455556666777788',
                'bank_name' => 'البنك السعودي للاستثمار',
                'business_license' => '3333444455',
                'tax_number' => '300333444455003',
                'rating' => 0,
                'total_sales' => 0,
                'total_products' => 0,
            ],
            [
                'name' => 'متجر الكتب والقرطاسية',
                'name_en' => 'Books & Stationery Store',
                'email' => 'books@vendor.com',
                'password' => Hash::make('password'),
                'phone' => '0506667777',
                'description' => 'كتب ومستلزمات مكتبية وقرطاسية',
                'status' => 'active',
                'is_vendor' => true,
                'store_slug' => 'books-stationery',
                'banner_color' => '#8b5cf6',
                'commission_rate' => 10.00,
                'social_links' => [
                    'instagram' => 'https://instagram.com/books_stationery',
                    'facebook' => 'https://facebook.com/books.stationery',
                    'whatsapp' => '966506667777',
                ],
                'return_policy' => 'يمكن إرجاع الكتب خلال 7 أيام إذا لم يتم فتحها',
                'shipping_policy' => 'الشحن مجاني لجميع الطلبات',
                'bank_account' => 'SA6666777788889999000011',
                'bank_name' => 'بنك البلاد',
                'business_license' => '6666777788',
                'tax_number' => '300666777788003',
                'rating' => 4.6,
                'total_sales' => 0,
                'total_products' => 0,
            ],
        ];

        $created = 0;
        $updated = 0;

        foreach ($vendors as $vendorData) {
            $vendor = Company::updateOrCreate(
                ['email' => $vendorData['email']], // Find by email
                $vendorData // Update or create with this data
            );

            if ($vendor->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }

        if ($created > 0) {
            $this->command->info("✅ Created {$created} new vendors");
        }
        if ($updated > 0) {
            $this->command->info("✅ Updated {$updated} existing vendors");
        }
        if ($created === 0 && $updated === 0) {
            $this->command->warn('⚠️  No vendors created or updated');
        }
    }
}
