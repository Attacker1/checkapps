<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'user_fio' => 'Админ Админович Админов',
                'user_email' => 'demeja16@gmail.com',
                'password' => bcrypt('finiko_super_good'),
                'role' => 'admin',
            ],
        ];

        foreach($users as $user) {
            $newUser = new User();
            $newUser->user_fio = $user['user_fio'];
            $newUser->user_email = $user['user_email'];
            $newUser->password = $user['password'];
            $newUser->save();
            $newUser->refresh();

            if(isset($user['role'])) {
                $role = Role::where('slug', $user['role'])->first();

                if(!$role) {
                    return false;
                }

                $newUser->role()->attach($role);
            }
        }
    }
}
