<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'fname' => 'Admin',
                'mname' => 'System',
                'lname' => 'User',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'email' => 'admin@example.com',
                'phone' => '09123456789',
                'address' => 'Admin Office',
                'role_id' => 1,
            ],
            [
                'fname' => 'Employee',
                'mname' => 'System',
                'lname' => 'User',
                'username' => 'employee',
                'password' => Hash::make('employee123'),
                'email' => 'employee@example.com',
                'phone' => '09998887777',
                'address' => 'Employee Dept',
                'role_id' => 2,
            ],
            [
                'fname' => 'Vincenzo',
                'mname' => '',
                'lname' => 'Customer',
                'username' => 'vincenzo',
                'password' => Hash::make('123123'),
                'email' => 'vincenzo@example.com',
                'phone' => '09112223344',
                'address' => 'Customer Address',
                'role_id' => 3,
            ],
        ]);
    }
}