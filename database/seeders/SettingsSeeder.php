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
            'slug' => 'check_verify_quantity',
            'name' => 'Количество проверок чека',
            'value' => 5,
        ]);

        DB::table('settings')->insert([
            'slug' => 'check_verify_price',
            'name' => 'Вознаграждение за проверку',
            'value' => 5,
        ]);
    }
}
