<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Merchant::create([
            'merchant_code' => 'KIS123',
            'merchant_name' => 'Kantin Ibu Siti',
            'owner_name' => 'Ibu Siti',
            'email' => 'kantin.ibusiti@gmail.com',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'village_id' => 3674061001,
            'district_id' => 367406,
            'city_id' => 3674,
            'province_id' => 36,
            'is_active' => true,
        ]);

        Merchant::create([
            'merchant_code' => 'KIS456',
            'merchant_name' => 'Kantin Pak Budi',
            'owner_name' => 'Pak Budi',
            'email' => 'kantin.pakbudi@gmail.com',
            'phone' => '081234567891',
            'address' => 'Jl. Merdeka No. 124, Jakarta',
            'village_id' => 3674061001,
            'district_id' => 367406,
            'city_id' => 3674,
            'province_id' => 36,
            'is_active' => true,
        ]);
    }
}
