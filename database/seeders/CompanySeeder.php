<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('companies')->find(1) != null) return;

        DB::table('companies')->insert([
            'id' => 1,
            'name' => 'Diagro',
            'country_id' => 1
        ]);
    }
}
