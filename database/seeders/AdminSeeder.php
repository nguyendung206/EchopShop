<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'avatar' => '1.png',
            'status' => '1',
            'role' => '1',
        ]);
        Admin::create([
            'name' => 'Admin',
            'email' => '1@gmail.com',
            'password' => bcrypt('123'),
            'avatar' => '1.png',
            'status' => '1',
            'role' => '1',
        ]);
        Admin::create([
            'name' => 'Admin',
            'email' => '2@gmail.com',
            'password' => bcrypt('123'),
            'avatar' => '1.png',
            'status' => '1',
            'role' => '1',
        ]);
    }
}
