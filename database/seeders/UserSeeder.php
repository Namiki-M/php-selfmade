<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            'name' => 'Namiki Mutsuki',
            'email' => 'test1@test.com',
            'password' => Hash::make('password123'),
            'postal_code' => '101-0001',
            'pref_id' => 2,
            'city' => '渋谷区青山',
            'town' => '2-5-11',
            'building' => '渋谷ビル',
            'phone_number' => '060-9999-1111',
            'created_at' => '2021/01/01 11:11:11'
        ]);
    }
}
