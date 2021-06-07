<?php


namespace App\Services;

use App\Enum\PermissionsEnum;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enum\UserOrderByEnum;
use App\Enum\UserSearchByEnum;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;

class UserService
{
    public function user($user_id, $loadCheckHistory = false)
    {
        try {
            $user = User::query()->where('user_id', $user_id)->with('permissions')->withCount('checkHistory');

            if($loadCheckHistory === true) {
                $user->withCount('rejectedChecks');
                $user->withCount('approvedChecks');
            }

            $user = $user->first();

            if(!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            return new UserResource($user);
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
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

    public function users($paginate, $filter, $s = null, $searchBy = null, $isBanned = null) {
        $approvedFilters = UserOrderByEnum::values();
        $approvedSearchBy = UserSearchByEnum::values();

        $paginate = $paginate ?? 20;
        $filter = $filter && in_array(strtoupper($filter), $approvedFilters) ? strtoupper($filter) : UserOrderByEnum::DESC;

        $users = User::query();

        if($isBanned !== null) {
            $isBanned = $isBanned === 'true' ? 1 : 0;

            $users->where('is_banned', $isBanned);
        }

        if($s && ($searchBy && in_array(strtolower($searchBy), $approvedSearchBy))) {
            $searchBy = strtolower($searchBy);

            $users->where($searchBy, 'like', '%'. $s . '%');
        }

        $users->withCount('checkHistory')->orderBy('check_history_count', $filter);

        $users = $users->paginate($paginate)->withQueryString();

        $users->getCollection()->transform(function($user) {
            return new UserResource($user);
        });

        return $users;
    }

    public function blockUser($user_id) {
        try {
            $canBlock = Gate::check(PermissionsEnum::CAN_BLOCK_USERS['slug']);
            $currentUserID = auth()->id();

            if($canBlock === false) {
                throw new Exception('У вас нет прав для блокировки пользователей', 403);
            }

            $user = User::where('user_id', $user_id)->with('permissions')->first();

            if(!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $isUserCanAdmin = $user->permissions->filter(function($permission) {
                return (bool) $permission->slug === PermissionsEnum::CAN_VIEW_ADMIN_PAGES['slug'];
            });

            if($isUserCanAdmin && !Gate::check(PermissionsEnum::CAN_BLOCK_ADMIN['slug'])) {
                throw new Exception('У вас нет прав для блокировки пользователей с доступом к админ панели', 403);
            }

            if($currentUserID === $user->id) {
                throw new Exception('Вы не можете заблокировать сами себя', 403);
            }

            $user->is_banned = true;
            $user->save();

            return (object) [
                'message' => 'Пользователь ' . $user->user_fio . ' успешно заблокирован',
                'code' => 200,
            ];
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }

    public function unblockUser($user_id) {
        try {
            $canUnblock = Gate::check(PermissionsEnum::CAN_BLOCK_USERS['slug']);

            if($canUnblock === false) {
                throw new Exception('У вас нет прав для разблокировки пользователей', 403);
            }

            $user = User::where('user_id', $user_id)->with('permissions')->first();

            if(!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $isUserCanAdmin = $user->permissions->filter(function($permission) {
                return (bool) $permission->slug === PermissionsEnum::CAN_VIEW_ADMIN_PAGES['slug'];
            });

            if($isUserCanAdmin && !Gate::check(PermissionsEnum::CAN_BLOCK_ADMIN['slug'])) {
                throw new Exception('У вас нет прав для разблокировки пользователей с доступом к админ панели', 403);
            }

            $user->is_banned = false;
            $user->save();

            return (object) [
                'message' => 'Пользователь ' . $user->user_fio . ' успешно разблокирован',
                'code' => 200,
            ];
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }
}
