<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            TimezoneSeeder::class,
            LanguageSeeder::class,
            LocaleSeeder::class,
            CurrencySeeder::class,
            CountrySeeder::class,
            CompanySeeder::class,
            UserCompanySeeder::class,
            FrontendApplicationSeeder::class,
        ]);
    }
}
