<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
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
                'permissions' => [
                    PermissionsEnum::CAN_VIEW_ADMIN_PAGES['slug'],
                    PermissionsEnum::CAN_VIEW_USERS['slug'],
                    PermissionsEnum::CAN_BLOCK_USERS['slug'],
                    PermissionsEnum::CAN_BLOCK_ADMIN['slug'],
                    PermissionsEnum::CAN_EDIT_SETTINGS['slug'],
                ]
            ],
        ];

        if(!isset($moderator->error)) {
           foreach ($users as $user) {
                $newUser = new User($user['user_data']);
                $newUser->save();

                if(isset($user['permissions'])) {
                    $newUser->givePermissionsTo($user['permissions']);
                }
           }
        }

        // $fakeUsers = User::factory(50)->create();
        // $userPermissionGroup = [
        //     PermissionsEnum::CAN_VERIVY_CHECKS['slug'],
        // ];

        // foreach($fakeUsers as $fakeUser) {
        //     $fakeUser->givePermissionsTo($userPermissionGroup);
        // }
    }
}
