<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    private static array $countries = [
        ['name' => 'België', 'currency' => 'EUR']
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

        foreach(self::$countries as $country) {
            $currency = DB::table('currencies')->where('iso_4217', $country['currency'])->value('id');
            if(! empty($currency) && is_int($currency)) {
                DB::table('countries')->insert([
                    'name' => $country['name'],
                    'currency_id' => $currency,
                    'created_at' => $now
                ]);
            }
        }

        DB::commit();
    }
}
