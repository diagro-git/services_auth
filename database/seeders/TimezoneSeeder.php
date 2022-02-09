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
        if(DB::table('timezones')->find(1) != null) return;

        DB::table('timezones')->insert([
            'id' => 1,
            'name' => 'Europe/Brussels',
            'utc_offset' => '+01:00',
            'utc_dst_offset' => '+02:00',
        ]);
    }


}
