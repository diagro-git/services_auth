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
        DB::table('languages')->insert([
            'iso_639_2' => 'nld',
            'name_international' => 'Dutch',
            'name_native' => 'Nederlands',
        ]);
    }


}
