<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryCitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'country' => ['name_ar' => 'المملكة العربية السعودية', 'name_en' => 'Saudi Arabia', 'code' => 'SA', 'phone_code' => '+966', 'status' => 'used'],
                'cities'  => [
                    ['name_ar' => 'الرياض',  'name_en' => 'Riyadh',  'shipping_price' => 20],
                    ['name_ar' => 'جدة',     'name_en' => 'Jeddah',  'shipping_price' => 25],
                    ['name_ar' => 'مكة المكرمة', 'name_en' => 'Mecca','shipping_price' => 25],
                    ['name_ar' => 'المدينة المنورة', 'name_en' => 'Medina', 'shipping_price' => 30],
                    ['name_ar' => 'الدمام',  'name_en' => 'Dammam',  'shipping_price' => 30],
                    ['name_ar' => 'الخبر',   'name_en' => 'Khobar',  'shipping_price' => 30],
                    ['name_ar' => 'أبها',    'name_en' => 'Abha',    'shipping_price' => 35],
                    ['name_ar' => 'تبوك',    'name_en' => 'Tabuk',   'shipping_price' => 35],
                ],
            ],
            [
                'country' => ['name_ar' => 'الإمارات العربية المتحدة', 'name_en' => 'United Arab Emirates', 'code' => 'AE', 'phone_code' => '+971', 'status' => 'used'],
                'cities'  => [
                    ['name_ar' => 'دبي',      'name_en' => 'Dubai',      'shipping_price' => 40],
                    ['name_ar' => 'أبوظبي',   'name_en' => 'Abu Dhabi',  'shipping_price' => 40],
                    ['name_ar' => 'الشارقة',  'name_en' => 'Sharjah',    'shipping_price' => 45],
                    ['name_ar' => 'عجمان',    'name_en' => 'Ajman',      'shipping_price' => 45],
                ],
            ],
            [
                'country' => ['name_ar' => 'الكويت', 'name_en' => 'Kuwait', 'code' => 'KW', 'phone_code' => '+965', 'status' => 'used'],
                'cities'  => [
                    ['name_ar' => 'مدينة الكويت', 'name_en' => 'Kuwait City', 'shipping_price' => 50],
                    ['name_ar' => 'حولي',         'name_en' => 'Hawalli',     'shipping_price' => 50],
                    ['name_ar' => 'الفروانية',    'name_en' => 'Farwaniya',   'shipping_price' => 50],
                ],
            ],
            [
                'country' => ['name_ar' => 'البحرين', 'name_en' => 'Bahrain', 'code' => 'BH', 'phone_code' => '+973', 'status' => 'used'],
                'cities'  => [
                    ['name_ar' => 'المنامة', 'name_en' => 'Manama',   'shipping_price' => 50],
                    ['name_ar' => 'المحرق',  'name_en' => 'Muharraq', 'shipping_price' => 50],
                ],
            ],
            [
                'country' => ['name_ar' => 'قطر', 'name_en' => 'Qatar', 'code' => 'QA', 'phone_code' => '+974', 'status' => 'used'],
                'cities'  => [
                    ['name_ar' => 'الدوحة',   'name_en' => 'Doha',      'shipping_price' => 50],
                    ['name_ar' => 'الريان',   'name_en' => 'Al Rayyan', 'shipping_price' => 50],
                ],
            ],
        ];

        foreach ($data as $entry) {
            $country = Country::updateOrCreate(
                ['code' => $entry['country']['code']],
                $entry['country']
            );

            foreach ($entry['cities'] as $city) {
                    City::updateOrCreate(
                    ['name_en' => $city['name_en'], 'country_id' => $country->id],
                    array_merge($city, ['country_id' => $country->id, 'status' => 'used'])
                );
            }
        }
    }
}
