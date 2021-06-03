<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
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
        $permissions = PermissionsEnum::values();

        foreach ($permissions as $permission) {
            $newPermission = new Permission($permission);
            $newPermission->save();
        }
    }
}
