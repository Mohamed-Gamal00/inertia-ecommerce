<?php

namespace Database\Seeders;

use App\Models\StoreFatuer;
use Illuminate\Database\Seeder;

class StoreFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['title' => 'شحن سريع',         'title_en' => 'Fast Shipping',       'description' => 'نوصل طلبك في أسرع وقت ممكن'],
            ['title' => 'دفع آمن',           'title_en' => 'Secure Payment',      'description' => 'جميع المدفوعات مشفرة وآمنة'],
            ['title' => 'إرجاع مجاني',       'title_en' => 'Free Returns',        'description' => 'إرجاع مجاني خلال 14 يوم'],
            ['title' => 'دعم على مدار الساعة','title_en' => '24/7 Support',       'description' => 'فريق الدعم متاح دائماً لمساعدتك'],
            ['title' => 'منتجات أصلية',      'title_en' => 'Authentic Products',  'description' => 'جميع منتجاتنا أصلية 100%'],
        ];

        foreach ($features as $feature) {
            StoreFatuer::updateOrCreate(['title' => $feature['title']], $feature);
        }
    }
}
