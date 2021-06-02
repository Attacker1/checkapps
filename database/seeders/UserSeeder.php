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
        $moderator = $this->moderatorService->getModerator();
        $role = Role::where('slug', 'admin')->first();

        if(!isset($moderator->error)) {
            $newUser = new User();
            $newUser->user_fio = $moderator->info->user_fio;
            $newUser->user_email = $moderator->info->user_email;
            $newUser->password = bcrypt($this->moderatorService->getModeratorCreditnails()['password']);
            $newUser->user_id = $moderator->info->user_id;
            $newUser->user_phone = $moderator->info->user_phone;
            $newUser->referer_user_id = $moderator->info->referer_user_id;
            $newUser->referer_user_fio = $moderator->info->referer_user_fio;
            $newUser->career_id = $moderator->info->career_id;
            $newUser->token_id = $moderator->token_id;
            $newUser->role_id = $role->id;

            $newUser->save();
        }

        User::factory(200)->create();
    }
}
