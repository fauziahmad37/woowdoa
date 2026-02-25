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
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'is_active' => true,
        ]);

    }
}
