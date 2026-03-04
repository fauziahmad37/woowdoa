<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Merchant;
use App\Models\MerchantOwner;
use Illuminate\Support\Facades\Hash;

class MerchantOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MerchantOwner::create([
            'owner_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '081234567890',
            'address' => '123 Main Street, City, Country',
            'merchant_id' => 1,
            'province_id' => 1,
            'city_id' => 1,
            'district_id' => 1,
            'village_id' => 1,
            'is_active' => true,
        ]);
    }
}
