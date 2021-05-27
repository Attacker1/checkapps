<?php


namespace App\Services;

use App\Enum\CheckHistoryStatusEnum;
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

    public function checkHistories($userID, $paginate = 20)
    {
        try {
            $user = User::find($userID);

            if (!$user) {
                throw new Exception('Пользователь не найден');
            }

            $checkHistories = $user->checkHistory()->with('check')->paginate($paginate);

            $checkHistories->getCollection()->transform(function ($checkHistory) {
                unset(
                    $checkHistory['updated_at'],
                    $checkHistory['check']['dt'],
                    $checkHistory['check']['dt_purchase'],
                    $checkHistory['check']['updated_at'],
                    $checkHistory['check']['created_at']
                );

                return $checkHistory;
            });

            return $checkHistories;
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }
}
