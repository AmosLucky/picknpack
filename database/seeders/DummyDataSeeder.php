<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_quarterly_summary')->insert([
            'id' => Str::uuid(),
            'facility_id' => 'kwara_state_store',
            'product_id' => 'pk1',
            'quarter' => 'q3_26',
            'opening' => 100,
            'received' => 500,
            'issued' => 200,
            'remarks' => 'Dummy data',
        ]);

        DB::table('product_batches')->insert([
            'product_id' => 'pk1',
            'initiator' => 'kwara_state_store',
            'batch_no' => 'DUMMY001',
            'expiry_date' => '2028-12-31',
            'q_reference' => null,
            'quantity' => 400,
            'created_at' => now(),
        ]);

        DB::table('facilities_info')->insert([
            'id' => Str::uuid(),
            'zone' => 'sw',
            'state' => 'kwara',
            'lga' => 'ILORIN',
            'name' => 'Dummy Facility',
            'inventory_id' => 'dummy_store',
            'facility_type' => 'facility',
            'date_updated' => now(),
        ]);

        DB::table('inventory')->insert([
            'inventory_id' => 'dummy_store',
            'product_id' => 'pk1',
            'batch_id' => 1,
            'current_quantity' => 400,
            'last_updated' => now(),
        ]);

        DB::table('orders')->insert([
            'sender_facility_id' => 'fcms_national_store',
            'receiver_facility_id' => 'dummy_store',
            'order_type' => 'Supply',
            'status' => 'pending',
            'created_by' => 'fcms_national_store',
            'sent_date' => now(),
            'confirmed_date' => null,
            'cancelled_date' => null,
            'cancellation_reason' => null,
            'updated_at' => now(),
        ]);

        DB::table('orderItems')->insert([
            'order_id' => 1,
            'product_id' => 'pk1',
            'batch_id' => 1,
            'sent_quantity' => 100,
            'received_quantity' => 0,
            'status' => 'pending',
            'created_at' => now(),
            'receiver_notes' => null,
            'updated_at' => now(),
            'cancelled_date' => null,
            'cancellation_reason' => null,
        ]);

        DB::table('inventory_transactions')->insert([
            'initiator_id' => 'fcms_national_store',
            'counterpart_id' => 'dummy_store',
            'product_id' => 'pk1',
            'order_id' => 1,
            'batch_id' => 1,
            'transaction_type' => 'Supply',
            'quantity_change' => -100,
            'transaction_date' => now(),
            'user_id' => 'fcms_national_store',
            'notes' => 'Dummy transaction',
            'created_at' => now(),
        ]);

        DB::table('qriff')->insert([
            'id' => Str::uuid(),
            'facility_id' => Str::uuid(),
            'product_id' => 'pk1',
            'opening' => 100,
            'received' => 500,
            'issued' => 200,
            'physical' => 400,
            'cases' => 4,
            'remarks' => 'Dummy data',
            'quarter' => 'q3_26',
        ]);

        DB::table('batch_data')->insert([
            'id' => Str::uuid(),
            'product_summary_id' => DB::table('product_quarterly_summary')->value('id'),
            'batch_no' => 'DUMMY001',
            'expiry_date' => '2028-12-31',
            'quantity' => 400,
        ]);
    }
}