<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('currencies')->find(1) != null) return;

        DB::table('currencies')->insert([
            'id' => 1,
            'name' => 'Euro',
            'iso_4217' => 'EUR',
        ]);
    }
}
