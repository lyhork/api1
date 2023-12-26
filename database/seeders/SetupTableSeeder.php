<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{


        DB::table('telegram')->insert(
            [
                [
                    'channel'   => 'Survey Comment',
                    'chat_id'   => '-1001986032625',
                    'slug'      => 'CHANNEL_SURVEY_CHAT_ID'
                ]
            ]
        );
                
	}
}
