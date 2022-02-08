<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name_native' => 'België',
            'name_international' => 'Belgium',
            'iso_3166_1' => 'BEL',
            'currency_id' => 1,
        ]);
    }
}
