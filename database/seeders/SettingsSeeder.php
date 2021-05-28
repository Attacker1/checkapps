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

        $settings = [
            [
                'slug' => SettingSlugEnum::CHECK_VERIFY_QUANTITY,
                'name' => 'Количество проверок чека',
                'value' => 5,
            ],
            [
                'slug' => SettingSlugEnum::CHECK_VERIFY_PRICE,
                'name' => 'Вознаграждение за проверку',
                'value' => 5,
            ],
            [
                'slug' => SettingSlugEnum::CHECK_EXPIRITY_TIME,
                'name' => 'Срок жизни чека',
                'value' => 72,
            ],
        ];

        foreach($settings as $rawSetting) {
            $setting1 = new Setting([
                'slug' => $rawSetting['slug'],
                'name' => $rawSetting['name'],
                'value' => $rawSetting['value'],
            ]);
            $setting1->save();
        }
    }
}
