<?php

namespace Database\Seeders;

use App\Models\Setting;
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

        $setting1 = new Setting([
            'slug' => 'check_verify_quantity',
            'name' => 'Количество проверок чека',
            'value' => 5,
        ]);

        $setting1->save();

        $setting2 = new Setting([
            'slug' => 'check_verify_price',
            'name' => 'Вознаграждение за проверку',
            'value' => 5,
        ]);

        $setting2->save();
    }
}
