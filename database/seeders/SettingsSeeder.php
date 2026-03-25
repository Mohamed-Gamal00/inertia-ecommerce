<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'website_name'    => 'متجري',
                'website_name_en' => 'My Store',
                'email'           => 'info@mystore.com',
                'phone'           => '+966500000000',
                'phone_number'    => '+966500000000',
                'address'         => 'الرياض، المملكة العربية السعودية',
                'description'     => 'متجر إلكتروني متكامل',
                'value_added_tax' => 15,
            ]
        );
    }
}
