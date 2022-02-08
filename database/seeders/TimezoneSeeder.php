<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timezones')->insert([
            'name' => 'Europe/Brussels',
            'utc_offset' => '+01:00',
            'utc_dst_offset' => '+02:00',
        ]);
    }


}
