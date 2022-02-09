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
        if(DB::table('user_companies')->find(1) != null) return;

        DB::table('user_companies')->insert([
            'id' => 1,
            'user_id' => 1,
            'company_id' => 1,
            'role_id' => 1,
        ]);
    }
}
