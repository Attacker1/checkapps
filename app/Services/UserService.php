<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Http\Request;

class UserService
{

    public function user(Request $request)
    {
        $user = $request->user();

        return $user->only([
            'id',
            'user_id',
            'user_fio',
            'user_email',
            'balance',
        ]);
    }

    public function userExists($userEmail)
    {
        $user = User::byEmail($userEmail)->first();
        return $user ? $user : false;
    }
}
