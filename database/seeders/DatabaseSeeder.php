<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RegulatorSeeder::class,
            UserSeeder::class,
            SurveySeeder::class,
            SetupTableSeeder::class
        ]);
    }
}
