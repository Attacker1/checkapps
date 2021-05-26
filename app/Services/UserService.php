<?php


namespace App\Services;


use App\Models\User;
use Exception;
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
        return User::byEmail($userEmail)->first() ?? false;
    }

    public function checkHistories($userID) {
        try {
            $user = User::find($userID);

            if(!$user) {
                throw new Exception('Пользователь не найден');
            }

            return $checkHistories = $user->checkHistory()->orderBy('created_at')->paginate(2);
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }
}
