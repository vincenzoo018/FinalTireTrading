<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'supplier_name' => 'Auto Supply Depot',
                'company_name' => 'AutoParts Co.',
                'address' => '123 Auto Street, Metro City',
                'contact_person' => 'John Doe',
                'contact_number' => '09112223333',
                'email' => 'john@autoparts.com',
                'payment_terms' => '30 days',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_name' => 'Engine Solutions',
                'company_name' => 'Engine Masters Inc.',
                'address' => '456 Engine Ave, Industrial Park',
                'contact_person' => 'Jane Smith',
                'contact_number' => '09223334444',
                'email' => 'jane@enginemasters.com',
                'payment_terms' => 'Cash on Delivery',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_name' => 'Wheels R Us',
                'company_name' => 'Wheel Works',
                'address' => '789 Wheel Blvd, Suburbia',
                'contact_person' => 'Mike Johnson',
                'contact_number' => '09334445555',
                'email' => 'mike@wheelworks.com',
                'payment_terms' => 'Net 15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}