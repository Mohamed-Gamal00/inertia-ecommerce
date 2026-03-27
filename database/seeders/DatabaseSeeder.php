<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(AdvertisementSeeder::class);
        $this->call(CountryCitySeeder::class);
        $this->call(StoreFeaturesSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(DesignSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
