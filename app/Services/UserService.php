<?php


namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enum\CheckHistoryStatusEnum;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function user(Request $request)
    {
        $user_id = $request->user()->user_id;
        $user = User::where('user_id', $user_id)->withCount('checkHistory')->first()->only([
            'id',
            'user_id',
            'user_fio',
            'user_email',
            'balance',
            'check_history_count'
        ]);

        return $user;
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

    public function all($paginate, $filter) {
        $approvedFilters = [
            'DESC' => 'DESC',
            'ASC' => 'ASC',
        ];

        $filter = empty($approvedFilters[$filter]) ? $approvedFilters['DESC'] : $approvedFilters[$filter];

        $users = User::withCount('checkHistory')->orderBy('check_history_count', $filter)->paginate($paginate);

        $users->getCollection()->transform(function($user) {
            unset(
                $user['password'],
                $user['created_at'],
                $user['updated_at'],
                $user['token_id'],
                $user['career_id'],
                $user['referer_user_fio'],
                $user['referer_user_id'],
            );

            return $user;
        });

        return $users;
    }
}
