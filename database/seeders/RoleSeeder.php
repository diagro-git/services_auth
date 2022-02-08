<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    private static array $roles = [
        'Root',
        'Manager',
        'Employee',
        'Sales',
        'Buyer',
        'Finance',
        'IT',
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

        foreach(self::$roles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'created_at' => $now
            ]);
        }

        DB::commit();
    }
}
