<?php

namespace Database\Seeders;

use App\Enum\RolesEnum;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = RolesEnum::values();
        $permissions = Permission::all();

        foreach ($roles as $role) {
            $newRole = new Role($role['role_data']);
            $newRole->save();


            foreach($role['permissions'] as $rolePermission) {
                $permission = $permissions->filter(function($item) use ($rolePermission) {
                    return $item->slug === $rolePermission['slug'];
                })->first();

                if($permission) {
                    $newRole->permissions()->attach($permission);
                }
            }
        }
    }
}
