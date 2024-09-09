<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $categoryIds = \App\Models\Category::pluck('id')->toArray();
        $brandIds = \App\Models\Brand::pluck('id')->toArray();

        // Lặp qua và tạo 20 sản phẩm
        for ($i = 0; $i < 20; $i++) {
            DB::table('products')->insert([
                'slug' => Str::slug('Product '.$i),
                'name' => 'Product '.$i,
                'price' => $faker->randomFloat(2, 10, 1000),
                'type' => rand(1, 3), 
                'photo' => 'noproduct.png', 
                'list_photo' => json_encode([$faker->imageUrl(200, 200)]), 
                'status' => rand(1, 2), 
                'description' => 'Description for Category ' . $i,
                'brand_id' => $faker->randomElement($brandIds), 
                'category_id' => $faker->randomElement($categoryIds), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
