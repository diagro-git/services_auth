<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('locales')->find(1) != null) return;

        DB::table('locales')->insert([
            'id' => 1,
            'identifier' => 'nl-BE',
            'language_id' => 1,
        ]);
    }
}
