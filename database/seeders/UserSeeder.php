<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'name' => 'admin',
                'address' => 'Sidoarjo Juanda',
                'level' => 1
            ],
            [
                'username' => 'staff',
                'email' => 'staff@staff.com',
                'password' => Hash::make('staff'),
                'name' => 'staff',
                'address' => 'Sidoarjo Juanda',
                'level' => 2
            ]
        ]);
    }
}
