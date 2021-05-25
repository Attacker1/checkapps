<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'check_verify_quantity',
            'value' => 5,
        ]);

        DB::table('settings')->insert([
            'name' => 'check_verify_price',
            'value' => 5,
        ]);

        DB::table('settings')->insert([
            'name' => 'check_lifetime',
            'value' => 48,
        ]);
    }
}
