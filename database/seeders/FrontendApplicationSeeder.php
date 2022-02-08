<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontendApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frontend_applications')->insert([
            'name' => 'Postman',
            'description' => 'Postman testing programma',
            'app_type' => 0,
        ]);
    }
}
