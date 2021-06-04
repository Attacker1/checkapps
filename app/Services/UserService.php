<?php


namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enum\UserOrderByEnum;
use App\Enum\UserSearchByEnum;
use App\Http\Resources\UserResource;

class UserService
{
    public function user(Request $request)
    {
        $user_id = $request->user()->user_id;
        $user = User::query()->where('user_id', $user_id)->withCount('checkHistory')->with('roles')->first();

        return new UserResource($user);
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

    public function users($paginate, $filter, $s = null, $searchBy = null) {
        $approvedFilters = UserOrderByEnum::values();
        $approvedSearchBy = UserSearchByEnum::values();

        $paginate = $paginate ?? 20;
        $filter = $filter && in_array(strtoupper($filter), $approvedFilters) ? strtoupper($filter) : UserOrderByEnum::DESC;

        $users = User::query();

        if($s && ($searchBy && in_array(strtolower($searchBy), $approvedSearchBy))) {
            $searchBy = strtolower($searchBy);

            $users->where($searchBy, 'like', '%'. $s . '%');
        }

        $users
            ->withCount('checkHistory')
            ->with('roles')
            ->orderBy('check_history_count', $filter);

        $users = $users->paginate($paginate);

        $users->getCollection()->transform(function($user) {
            return new UserResource($user);
        });

        return $users;
    }
}
