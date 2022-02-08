<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_companies')->insert([
            'user_id' => 1,
            'company_id' => 1,
            'role_id' => 1,
        ]);
    }
}
