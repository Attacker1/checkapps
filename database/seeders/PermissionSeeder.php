<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Проверка чеков',
                'slug' => 'verify_check',
            ],
            [
                'name' => 'Изменение настроек',
                'slug' => 'edit_settings',
            ],
            [
                'name' => 'Блокировать пользователей',
                'slug' => 'block_users',
            ],
        ];


        foreach ($permissions as $permission) {
            $newPermission = new Permission($permission);
            $newPermission->save();
        }
    }
}
