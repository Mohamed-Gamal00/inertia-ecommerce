<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\ShippingTypesAndPrice;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'قيد الانتظار',    'name_en' => 'Pending',     'default_status' => true,  'arrangement' => 1],
            ['name' => 'تم التأكيد',      'name_en' => 'Confirmed',   'default_status' => false, 'arrangement' => 2],
            ['name' => 'قيد التجهيز',     'name_en' => 'Processing',  'default_status' => false, 'arrangement' => 3],
            ['name' => 'تم الشحن',        'name_en' => 'Shipped',     'default_status' => false, 'arrangement' => 4],
            ['name' => 'تم التسليم',      'name_en' => 'Delivered',   'default_status' => false, 'arrangement' => 5],
            ['name' => 'ملغي',            'name_en' => 'Cancelled',   'default_status' => false, 'arrangement' => 6],
        ];

        foreach ($statuses as $status) {
            OrderStatus::updateOrCreate(['name_en' => $status['name_en']], $status);
        }

        // Shipping types config (single row, id=1)
        ShippingTypesAndPrice::updateOrCreate(['id' => 1], [
            'add_pickup_from_store'  => false,
            'add_wight_price'        => false,
            'add_normal_price'       => true,
            'add_price_based_on_city'=> false,
            'weight_price'           => 0,
            'normal_shipping_price'  => 20,
        ]);
    }
}
