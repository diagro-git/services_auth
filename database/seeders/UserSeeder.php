<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->find(1) != null) return;

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Diagro',
            'email' => 'diagro@diagro.dev',
            'password' => Hash::make("password"),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'remember_token' => Str::random(10),
            'locale_id' => 1,
            'timezone_id' => 1,
        ]);
    }
}
