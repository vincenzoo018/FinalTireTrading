<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['role_id' => 1, 'position' => 'admin'],
            ['role_id' => 2, 'position' => 'employee'],
            ['role_id' => 3, 'position' => 'customer'],
        ]);
    }
}