<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{


    private static array $timezones = [
        ['name' => 'GMT', 'offset' => '+00:00', 'dst' => '+00:00'],
        ['name' => 'UTC', 'offset' => '+00:00', 'dst' => '+00:00'],
        ['name' => 'Europe/Brussels', 'offset' => '+01:00', 'dst' => '+02:00'],
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $now = Carbon::now()->format('Y-m-d H:i:s');

        foreach(self::$timezones as $timezone) {
            DB::table('timezones')->insert([
                'name' => $timezone['name'],
                'utc_offset' => $timezone['offset'],
                'utc_dst_offset' => $timezone['dst'],
                'created_at' => $now
            ]);
        }

        DB::commit();
    }


}
