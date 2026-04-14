<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Check if settings table exists
            if (!Schema::hasTable('settings')) {
                $this->command->warn('Settings table does not exist. Skipping seeder.');
                return;
            }

            // Get all columns that exist in the settings table
            $columns = Schema::getColumnListing('settings');
            $this->command->info('Available columns: ' . implode(', ', $columns));
            
            // Define the data we want to seed with minimal required fields
            $settingsData = [
                'email' => 'info@mystore.com',
                'phone' => '+966500000000',
                'address' => 'الرياض، المملكة العربية السعودية',
                'description' => 'متجر إلكتروني متكامل',
            ];
            
            // Add optional fields if they exist
            if (in_array('website_name', $columns)) {
                $settingsData['website_name'] = 'متجري';
            }
            if (in_array('website_name_en', $columns)) {
                $settingsData['website_name_en'] = 'My Store';
            }
            if (in_array('phone_number', $columns)) {
                $settingsData['phone_number'] = '+966500000000';
            }
            if (in_array('value_added_tax', $columns)) {
                $settingsData['value_added_tax'] = 15;
            }
            
            // Filter data to only include columns that exist in the table
            $filteredData = [];
            foreach ($settingsData as $key => $value) {
                if (in_array($key, $columns)) {
                    $filteredData[$key] = $value;
                }
            }
            
            // Only proceed if we have data to insert
            if (!empty($filteredData)) {
                // Check if record exists
                $exists = DB::table('settings')->where('id', 1)->exists();
                
                if ($exists) {
                    // Update existing record
                    DB::table('settings')->where('id', 1)->update(array_merge($filteredData, [
                        'updated_at' => now()
                    ]));
                    $this->command->info('Settings updated successfully.');
                } else {
                    // Insert new record
                    $filteredData['id'] = 1;
                    $filteredData['created_at'] = now();
                    $filteredData['updated_at'] = now();
                    DB::table('settings')->insert($filteredData);
                    $this->command->info('Settings created successfully.');
                }
            } else {
                $this->command->warn('No matching columns found in settings table.');
            }
        } catch (\Exception $e) {
            $this->command->error('Settings seeder failed: ' . $e->getMessage());
            // Don't throw the exception to prevent deployment failure
        }
    }
}
