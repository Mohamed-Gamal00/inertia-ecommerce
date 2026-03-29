<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['name' => 'سامسونج',  'name_en' => 'Samsung'],
            ['name' => 'آبل',      'name_en' => 'Apple'],
            ['name' => 'سوني',     'name_en' => 'Sony'],
            ['name' => 'إل جي',    'name_en' => 'LG'],
            ['name' => 'نايكي',    'name_en' => 'Nike'],
            ['name' => 'أديداس',   'name_en' => 'Adidas'],
            ['name' => 'إيكيا',    'name_en' => 'IKEA'],
            ['name' => 'فيليبس',   'name_en' => 'Philips'],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(['name_en' => $company['name_en']], $company);
        }
    }
}
