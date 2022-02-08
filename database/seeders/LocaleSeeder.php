<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaleSeeder extends Seeder
{
    private static array $locales = [
        ['id' => 'en-GB', 'lang' => 'EN'],
        ['id' => 'nl-BE', 'lang' => 'NL'],
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

        foreach(self::$locales as $locale) {
            $language = DB::table('languages')->where('code', $locale['lang'])->value('id');
            if(! empty($language) && is_int($language)) {
                DB::table('locales')->insert([
                    'identifier' => $locale['id'],
                    'language_id' => $language,
                    'created_at' => $now
                ]);
            }
        }

        DB::commit();
    }
}
