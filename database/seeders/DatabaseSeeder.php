<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Ngô Quang Vinh',
            'username' => 'vinhhp',
            'email' => 'vinhhp2620@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-26',
        ]);
        $lvv = User::create([
            'name' => 'Higo',
            'username' => 'lvv',
            'email' => 'higo2952@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-01-11',
        ]);
        $lvv = User::create([
            'name' => 'The King',
            'username' => 'qvuong',
            'email' => 'qvuong2106@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
        ]);
    }
}
