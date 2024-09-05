<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@gmail.com',
            'password' => bcrypt('123'),
            'avatar' => 'nophoto.png',
            'phone_number' => '1234567890',
            'citizen_identification_number' => '123456789012',
            'date_of_issue' => '2024-08-06',
            'place_of_issue' => 'Thành Phố Huế',
            'date_of_birth' => '2024-08-06',
            'gender' => '0',
            'address' => '100 Tố Hữu',
            'status' => '0',
            'role' => '1',
        ]);
    }
}
