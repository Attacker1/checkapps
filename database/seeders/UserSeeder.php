<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\Admin\ModeratorService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $moderatorService;

    public function __construct(ModeratorService $moderatorService)
    {
        $this->moderatorService = $moderatorService;
    }

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
                'user_email' => 'chekapps.com@gmail.com',
                'password' => bcrypt('HvJTP.3m,F5KtnH'),
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
                $moderator = $this->moderatorService->getModerator();

                if(!$role) {
                    return false;
                }

                $newUser->role()->attach($role);

                if(!isset($moderator->error)) {
                    $newUser->user_id = $moderator->info->user_id;
                    $newUser->save();
                }
            }
        }
    }
}
