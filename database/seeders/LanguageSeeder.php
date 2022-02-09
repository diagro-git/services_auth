<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('languages')->find(1) != null) return;

        DB::table('languages')->insert([
            'id' => 1,
            'iso_639_2' => 'nld',
            'name_international' => 'Dutch',
            'name_native' => 'Nederlands',
        ]);
    }


}
