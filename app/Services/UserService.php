<?php


namespace App\Services;


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
}
