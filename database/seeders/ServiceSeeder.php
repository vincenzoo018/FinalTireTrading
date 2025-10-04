<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'service_name' => 'Oil Change',
                'service_price' => 799.00,
                'description' => 'Complete engine oil replacement service.',
                'image' => 'images/services/oil-change.jpg',
                'employee_id' => 2, // Make sure employee with ID 2 exists
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'service_name' => 'Tire Rotation',
                'service_price' => 499.00,
                'description' => 'Front and rear tire rotation for even wear.',
                'image' => 'images/services/tire-rotation.jpg',
                'employee_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'service_name' => 'Battery Checkup',
                'service_price' => 299.00,
                'description' => 'Battery testing and diagnostics.',
                'image' => 'images/services/battery-check.jpg',
                'employee_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}