<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{

    private static array $languages = [
        ['code' => 'NL', 'int' => 'Dutch', 'native' => 'Nederlands'],
        ['code' => 'EN', 'int' => 'English', 'native' => 'English'],
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

        foreach(self::$languages as $language) {
            DB::table('languages')->insert([
                'code' => $language['code'],
                'name_international' => $language['int'],
                'name_native' => $language['native'],
                'created_at' => $now
            ]);
        }

        DB::commit();
    }


}
