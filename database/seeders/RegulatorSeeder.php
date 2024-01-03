<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        |-------------------------------------------------------------------------------
        | Add 7 Surveys
        |-------------------------------------------------------------------------------
        */
        DB::table('regulators')->insert(
            [
                [
                    'name' => 'និយ័តករគណនេយ្យនិងសវនកម្ម',
                    'image' => 'static/Regulators/ACAR.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'និយ័តករធានារ៉ាប់រងកម្ពុជា',
                    'image' => 'static/Regulators/IRC.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'និយ័តករអាជីវកម្មអចលនវត្ថុនិងបញ្ចាំ',
                    'image' => 'static/Regulators/REBP.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'និយ័តករមូលបត្រកម្ពុជា',
                    'image' => 'static/Regulators/SERC.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'និយ័តករសន្តិសុខសង្គម',
                    'image' => 'static/Regulators/SSR.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'និយ័តករបរធនបាលកិច្ច',
                    'image' => 'static/Regulators/TR.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ការរិយាល័យច្រកចេញចូលតែមួយ',
                    'image' => 'static/Regulators/logo.png',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        );
    }
}
