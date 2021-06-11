<?php

namespace Database\Seeders;

use App\Enum\SettingSlugEnum;
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

        $settings = SettingSlugEnum::values();

        foreach($settings as $rawSetting) {
            $setting = new Setting($rawSetting);
            $setting->save();
        }
    }
}
