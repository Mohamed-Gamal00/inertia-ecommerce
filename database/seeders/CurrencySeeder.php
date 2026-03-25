<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            // Default currency - SAR, always 'used'
            ['name' => 'Saudi Riyal',    'name_ar' => 'ريال سعودي',      'code' => 'SAR', 'symbol' => 'ر.س', 'price_in_default_currency' => 1,      'default_currency' => true,  'status' => 'used'],
            ['name' => 'US Dollar',      'name_ar' => 'دولار أمريكي',    'code' => 'USD', 'symbol' => '$',   'price_in_default_currency' => 0.2667, 'default_currency' => false, 'status' => 'used'],
            ['name' => 'Euro',           'name_ar' => 'يورو',             'code' => 'EUR', 'symbol' => '€',   'price_in_default_currency' => 0.2459, 'default_currency' => false, 'status' => 'used'],
            ['name' => 'British Pound',  'name_ar' => 'جنيه إسترليني',   'code' => 'GBP', 'symbol' => '£',   'price_in_default_currency' => 0.2101, 'default_currency' => false, 'status' => 'not_used'],
            ['name' => 'UAE Dirham',     'name_ar' => 'درهم إماراتي',    'code' => 'AED', 'symbol' => 'د.إ', 'price_in_default_currency' => 0.9791, 'default_currency' => false, 'status' => 'not_used'],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }
}
