<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
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
        | Add Survey Type First because relationship from surveys_type to survey 1:M
        |-------------------------------------------------------------------------------
        */
        DB::table('survey_type')->insert(
            [
                [
                    'name' => 'ពេញចិត្តខ្លាំង',
                    'image'=> 'static/Survey/image-1.png'
                ],
                [
                    'name' => 'ពេញចិត្ត',
                    'image'=> 'static/Survey/image-2.png'
                ],
                [
                    'name' => 'ធម្មតា',
                    'image'=> 'static/Survey/image-3.png'
                ],
                [
                    'name' => 'មិនពេញចិត្ត',
                    'image'=> 'static/Survey/image-4.png'
                ],
                [
                    'name' => 'មិនពេញចិត្តខ្លាំង',
                    'image'=> 'static/Survey/image-5.png'
                ]
            ]
        );

        /*
        |-------------------------------------------------------------------------------
        | Add 1 Survey
        |-------------------------------------------------------------------------------
        */
        DB::table('survey')->insert(
            [
                [
                    'regulator_id'  => 1,
                    'type_id'       => 4,
                    'description'   => 'N/A',
                    'date_at'       => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
                ],
            ]
        );
    }
}
