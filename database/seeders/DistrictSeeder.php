<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::create([
            'district_name' => 'Thành phố huế',
            'province_id' => 1
        ]);
        District::create([
            'district_name' => 'Quảng điền', 
            'province_id' => 1
        ]);
        District::create([
            'district_name' => 'Thành phố Đà Nẵng', 
            'province_id' => 2
        ]);
    }
}
