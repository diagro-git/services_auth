<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    private static array $currencies = [
        ['name' => 'euro', 'iso' => 'EUR']
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

        foreach(self::$currencies as $currency) {
            DB::table('currencies')->insert([
                'name' => $currency['name'],
                'iso_4217' => $currency['iso'],
                'created_at' => $now
            ]);
        }

        DB::commit();
    }
}
