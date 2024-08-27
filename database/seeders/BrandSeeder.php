<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Brand::create([
                'slug' => Str::slug('Brand ' . $i),
                'name' => 'Brand ' . $i,
                'description' => 'Description for Brand ' . $i,
                'photo' => 'noproduct.png',
                'status' => rand(1, 2),
                'category_id' => 13,
            ]);
        }
    }
}
