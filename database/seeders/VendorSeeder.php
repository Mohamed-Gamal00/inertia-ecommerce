<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'name'        => 'متجر الإلكترونيات',
                'name_en'     => 'Electronics Store',
                'email'       => 'vendor@electronics.com',
                'password'    => Hash::make('password'),
                'phone'       => '+966501234567',
                'description' => 'متخصصون في أحدث الأجهزة الإلكترونية',
                'is_vendor'   => true,
                'status'      => 'active',
            ],
            [
                'name'        => 'متجر الأزياء',
                'name_en'     => 'Fashion Store',
                'email'       => 'vendor@fashion.com',
                'password'    => Hash::make('password'),
                'phone'       => '+966507654321',
                'description' => 'أحدث صيحات الموضة والأزياء',
                'is_vendor'   => true,
                'status'      => 'active',
            ],
            [
                'name'        => 'متجر المنزل',
                'name_en'     => 'Home Store',
                'email'       => 'vendor@home.com',
                'password'    => Hash::make('password'),
                'phone'       => '+966509876543',
                'description' => 'كل ما يحتاجه منزلك',
                'is_vendor'   => true,
                'status'      => 'pending',
            ],
        ];

        foreach ($vendors as $vendor) {
            Company::updateOrCreate(['email' => $vendor['email']], $vendor);
        }
    }
}
