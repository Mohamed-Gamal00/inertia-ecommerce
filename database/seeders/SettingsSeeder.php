<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Seed the settings table with initial application configuration.
     *
     * This seeder pulls payment gateway and SMS credentials from .env file
     * to populate the settings table. Make sure these are set in your .env:
     * - MOYASAR_PUBLISHABLE_KEY
     * - MOYASAR_SECRET_KEY
     * - SMS_API_KEY
     * - SMS_USER_NAME
     * - SMS_SENDER
     */
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
                'publishable_key' => env('MOYASAR_PUBLISHABLE_KEY'),
                'secret_key'      => env('MOYASAR_SECRET_KEY'),
                'sms_api_key'     => env('SMS_API_KEY'),
                'sms_user_name'   => env('SMS_USER_NAME'),
                'sms_sender'      => env('SMS_SENDER', 'MyStore'),
            ]
        );
    }
}
