<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        $moderator = $this->moderatorService->getModerator();
        $roles = Role::with('permissions')->get();
        // $permissions = Permission::all();

        $users = [
            [
                'user_data' => [
                    'user_fio' => $moderator->info->user_fio,
                    'user_email' => $moderator->info->user_email,
                    'password' => bcrypt($this->moderatorService->getModeratorCreditnails()['password']),
                    'user_id' => $moderator->info->user_id,
                    'user_phone' => $moderator->info->user_phone,
                    'referer_user_id' => $moderator->info->referer_user_id,
                    'referer_user_fio' => $moderator->info->referer_user_fio,
                    'career_id' => $moderator->info->career_id,
                    'token_id' => $moderator->token_id,
                ],
                'roles' => [
                    'admin',
                ]
            ],
        ];

        if(!isset($moderator->error)) {
           foreach ($users as $user) {
                $newUser = new User($user['user_data']);
                $newUser->save();

                if(isset($user['roles'])) {
                    foreach ($user['roles'] as $roleSlug) {
                        $role = $roles->filter(function ($item) use ($roleSlug) {
                            return $item->slug === $roleSlug;
                        })->first();

                        if($role) {
                            $newUser->roles()->attach($role);
                        }
                    }
                }
           }
        }

        $fakeUsers = User::factory(50)->create();

        foreach($fakeUsers as $fakeUser) {
            $role = $roles->filter(function ($item) use ($roleSlug) {
                return $item->slug === 'user';
            })->first();

            if($role) {
                $fakeUser->roles()->attach($role);
            }
        }
    }
}
