<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | National
        |--------------------------------------------------------------------------
        */

        DB::table('users')->updateOrInsert(
            ['email' => 'national@gmail.com'],
            [
                'name' => 'National User',
                'password' => Hash::make('11111111'),

                'role' => 'national',

                'region' => null,
                'zone' => null,
                'state' => null,
                'lga' => null,

                'store_id' => 'fcms_national_store',

                'phone' => null,

                'is_active' => true,

                'email_verified_at' => now(),

                'last_login_at' => null,

                'remember_token' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | South East Zonal
        |--------------------------------------------------------------------------
        */

        DB::table('users')->updateOrInsert(
            ['email' => 'se@gmail.com'],
            [
                'name' => 'South East Zonal User',
                'password' => Hash::make('11111111'),

                'role' => 'zone',

                'region' => 'se',
                'zone' => 'south_east',
                'state' => null,
                'lga' => null,

                'store_id' => 'south_east_zonal_store',

                'phone' => null,

                'is_active' => true,

                'email_verified_at' => now(),

                'last_login_at' => null,

                'remember_token' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Enugu State
        |--------------------------------------------------------------------------
        */

        DB::table('users')->updateOrInsert(
            ['email' => 'enugu@gmail.com'],
            [
                'name' => 'Enugu State User',
                'password' => Hash::make('11111111'),

                'role' => 'state',

                'region' => 'se',
                'zone' => 'south_east',
                'state' => 'enugu',
                'lga' => null,

                'store_id' => 'enugu_state_store',

                'phone' => null,

                'is_active' => true,

                'email_verified_at' => now(),

                'last_login_at' => null,

                'remember_token' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}