<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'santhosh',
            'lastname'=>'kumar',
            'mobile'=>'987654210',
            'email' => 'santhoshkumar2v@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
