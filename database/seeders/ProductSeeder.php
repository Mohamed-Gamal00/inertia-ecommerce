<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Company;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductAvailability;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Availabilities
        $inStock  = ProductAvailability::updateOrCreate(['name' => 'متاح'],    ['name_en' => 'In Stock']);
        $outStock = ProductAvailability::updateOrCreate(['name' => 'غير متاح'], ['name_en' => 'Out of Stock']);

        // Colors
        $red   = Color::updateOrCreate(['color_code' => '#FF0000'], ['name' => 'أحمر']);
        $blue  = Color::updateOrCreate(['color_code' => '#0000FF'], ['name' => 'أزرق']);
        $black = Color::updateOrCreate(['color_code' => '#000000'], ['name' => 'أسود']);
        $white = Color::updateOrCreate(['color_code' => '#FFFFFF'], ['name' => 'أبيض']);

        // Company
        $company = Company::updateOrCreate(
            ['name' => 'الشركة الافتراضية'],
            ['name_en' => 'Default Company']
        );

        // Categories
        $electronics = MainCategory::updateOrCreate(
            ['name' => 'إلكترونيات'],
            ['name_en' => 'Electronics', 'slug' => 'electronics']
        );

        $clothing = MainCategory::updateOrCreate(
            ['name' => 'ملابس'],
            ['name_en' => 'Clothing', 'slug' => 'clothing']
        );

        $home = MainCategory::updateOrCreate(
            ['name' => 'المنزل والمطبخ'],
            ['name_en' => 'Home & Kitchen', 'slug' => 'home-kitchen']
        );

        // Products
        $products = [
            [
                'name'                   => 'هاتف ذكي',
                'name_en'                => 'Smartphone',
                'description'            => 'هاتف ذكي بمواصفات عالية',
                'price'                  => 1999.00,
                'discount_price'         => 1799.00,
                'quantity'               => 50,
                'status'                 => "active",
                'is_special'             => true,
                'weight'                 => 0.2,
                'category_id'            => $electronics->id,
                'company_id'             => $company->id,
                'product_availability_id'=> $inStock->id,
                'colors'                 => [$black->id, $white->id],
            ],
            [
                'name'                   => 'لابتوب',
                'name_en'                => 'Laptop',
                'description'            => 'لابتوب للأعمال والدراسة',
                'price'                  => 3500.00,
                'discount_price'         => null,
                'quantity'               => 20,
                'status'                 => "active",
                'is_special'             => false,
                'weight'                 => 1.8,
                'category_id'            => $electronics->id,
                'company_id'             => $company->id,
                'product_availability_id'=> $inStock->id,
                'colors'                 => [$black->id],
            ],
            [
                'name'                   => 'تيشيرت قطني',
                'name_en'                => 'Cotton T-Shirt',
                'description'            => 'تيشيرت قطني مريح',
                'price'                  => 89.00,
                'discount_price'         => 69.00,
                'quantity'               => 200,
                'status'                 => "active",
                'is_special'             => false,
                'weight'                 => 0.3,
                'category_id'            => $clothing->id,
                'company_id'             => $company->id,
                'product_availability_id'=> $inStock->id,
                'colors'                 => [$red->id, $blue->id, $black->id, $white->id],
            ],
            [
                'name'                   => 'جاكيت شتوي',
                'name_en'                => 'Winter Jacket',
                'description'            => 'جاكيت دافئ للشتاء',
                'price'                  => 350.00,
                'discount_price'         => null,
                'quantity'               => 80,
                'status'                 => "active",
                'is_special'             => true,
                'weight'                 => 0.9,
                'category_id'            => $clothing->id,
                'company_id'             => $company->id,
                'product_availability_id'=> $inStock->id,
                'colors'                 => [$black->id, $blue->id],
            ],
            [
                'name'                   => 'مكنسة كهربائية',
                'name_en'                => 'Vacuum Cleaner',
                'description'            => 'مكنسة كهربائية قوية',
                'price'                  => 450.00,
                'discount_price'         => 399.00,
                'quantity'               => 30,
                'status'                 => "active",
                'is_special'             => false,
                'weight'                 => 3.5,
                'category_id'            => $home->id,
                'company_id'             => $company->id,
                'product_availability_id'=> $inStock->id,
                'colors'                 => [$white->id],
            ],
            [
                'name'                   => 'طقم أواني طبخ',
                'name_en'                => 'Cookware Set',
                'description'            => 'طقم أواني طبخ من الستانلس ستيل',
                'price'                  => 299.00,
                'discount_price'         => null,
                'quantity'               => 0,
                'status'                 => "active",
                'is_special'             => false,
                'weight'                 => 4.0,
                'category_id'            => $home->id,
                'company_id'             => $company->id,
                'product_availability_id'=> $outStock->id,
                'colors'                 => [],
            ],
        ];

        foreach ($products as $data) {
            $colors = $data['colors'];
            unset($data['colors']);

            $slug = str_replace(' ', '-', $data['name_en']);
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                array_merge($data, ['slug' => $slug])
            );

            if (!empty($colors)) {
                $product->colors()->syncWithoutDetaching($colors);
            }
        }
    }
}
