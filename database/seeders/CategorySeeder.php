<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Category::create([
                'slug' => Str::slug('Category '.$i),
                'name' => 'Category '.$i,
                'description' => 'Description for Category '.$i,
                'photo' => 'nophoto.png',
                'status' => rand(1, 2),
            ]);
        }
    }
}
