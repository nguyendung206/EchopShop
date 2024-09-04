<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'shop_name' => 'echop',
            'email' => 'echop@gmail.com',
            'hotline' => '1234567890',
            'password' => bcrypt('123'),
            'logo' => 'logo.png',
            'address' => 'Thừa Thiên Huế'
        ]);
    }
}
