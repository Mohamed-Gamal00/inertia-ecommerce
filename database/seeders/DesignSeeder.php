<?php

namespace Database\Seeders;

use App\Models\Design;
use Illuminate\Database\Seeder;

class DesignSeeder extends Seeder
{
    public function run(): void
    {
        $designs = [
            // Home page banners
            [
                'title'       => 'البانر الرئيسي',
                'page_name'   => 'home',
                'description' => 'البانر الرئيسي للصفحة الرئيسية',
            ],
            [
                'title'       => 'بانر العروض',
                'page_name'   => 'home',
                'description' => 'بانر عروض الصفحة الرئيسية',
            ],
            [
                'title'       => 'بانر المنتجات المميزة',
                'page_name'   => 'home',
                'description' => 'بانر المنتجات المميزة',
            ],
            // Offers page banners
            [
                'title'       => 'بانر صفحة العروض',
                'page_name'   => 'offers-page',
                'description' => 'البانر الرئيسي لصفحة العروض',
            ],
            [
                'title'       => 'بانر التخفيضات',
                'page_name'   => 'offers-page',
                'description' => 'بانر التخفيضات الموسمية',
            ],
        ];

        foreach ($designs as $design) {
            Design::updateOrCreate(
                ['title' => $design['title'], 'page_name' => $design['page_name']],
                $design
            );
        }
    }
}
