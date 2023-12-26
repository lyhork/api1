<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | Create User Type: Admin & Staff
        |--------------------------------------------------------------------------
        */
        DB::table('users_type')->insert(
            [
                ['en_name' => 'Admin', 'kh_name' => 'អ្នកគ្រប់គ្រង'],
                ['en_name' => 'Regulator', 'kh_name' => 'និយតករ']
            ]
        );
        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */
        $users =  [
            [
                'type_id' => 2,
                'regulator_id'=>1,
                'email' => 'acar@gmail.com',
                'phone' => '020000001',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Accounting and Auditing Regulator',
                'avatar' => 'static/Regulators/ACAR.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            [
                'type_id' => 2,
                'regulator_id'=>2,
                'email' => 'irc@gmail.com',
                'phone' => '020000002',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Insurance Regulator',
                'avatar' => 'static/Regulators/IRC.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            [
                'type_id' => 2,
                'regulator_id'=>3,
                'email' => 'bebp@gmail.com',
                'phone' => '020000003',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Real Estate Business and Pawnshop Regulator',
                'avatar' => 'static/Regulators/REBP.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id' => 2,
                'regulator_id'=>4,
                'email' => 'serc@gmail.com',
                'phone' => '020000004',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Securities and Exchange Regulator',
                'avatar' => 'static/Regulators/SERC.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            [
                'type_id' => 2,
                'regulator_id'=>5,
                'email' => 'ssr@gmail.com',
                'phone' => '020000005',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Social Security Regulator',
                'avatar' => 'static/Regulators/SSR.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            [
                'type_id' => 2,
                'regulator_id'=>6,
                'email' => 'tr@gmail.com',
                'phone' => '020000006',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Trust Regulator',
                'avatar' => 'static/Regulators/TR.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id' => 2,
                'regulator_id'=>7,
                'email' => 'fsa@gmail.com',
                'phone' => '020000007',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'FSA',
                'avatar' => 'static/Regulators/logo.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            [
                'type_id' => 1,
                'regulator_id'=>7,
                'email' => 'admin@gmail.com',
                'phone' => '020000008',
                'password' => bcrypt('123456'),
                'is_active' => 1,
                'name' => 'Admin',
                'avatar' => 'static/Regulators/logo.png',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            
        ];

        /*
        |--------------------------------------------------------------------------
        | Write To Database
        |--------------------------------------------------------------------------
        |
        | It will insert to table users of database minimart.
        |
        */
        DB::table('users')->insert($users);
    }
}
