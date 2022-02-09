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
        if(DB::table('frontend_applications')->find(1) != null) return;

        DB::table('frontend_applications')->insert([
            'id' => 1,
            'name' => 'Postman',
            'description' => 'Postman testing programma',
            'app_type' => 0,
        ]);
    }
}
