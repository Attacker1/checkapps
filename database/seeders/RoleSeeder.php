<?php

namespace Database\Seeders;

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
        $roles = [
            [
                'name' => 'Пользователь',
                'slug' => 'user',
                'permissions' => [
                    'verify_check',
                ]
            ],
            [
                'name' => 'Администратор',
                'slug' => 'admin',
                'permissions' => [
                    'verify_check',
                    'block_users',
                    'edit_settings',
                ]
            ],
        ];

        foreach ($roles as $role) {
            $newRole = new Role();
            $newRole->name = $role['name'];
            $newRole->slug = $role['slug'];
            $newRole->save();
            $newRole->refresh();

            if(isset($role['permissions'])) {
                foreach($role['permissions'] as $permission) {
                    $permission = Permission::where('slug', $permission)->first();

                    if(!$permission) {
                        return false;
                    }

                    $newRole->permissions()->attach($permission);
                }
            }
        }
    }
}
