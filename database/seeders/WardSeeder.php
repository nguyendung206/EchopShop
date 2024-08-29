<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ward;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ward::create([
            'ward_name' => 'An đông',
            'district_id' => 1,
        ]);
        Ward::create([
            'ward_name' => 'An cựu',
            'district_id' => 1,
        ]);
        Ward::create([
            'ward_name' => 'Tổ 1',
            'district_id' => 2,
        ]);
        Ward::create([
            'ward_name' => 'Phường 1',
            'district_id' => 3,
        ]);
    }
}
