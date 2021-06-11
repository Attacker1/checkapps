<?php
namespace App\Services;

use App\Enum\PermissionsEnum;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Gate;

class PermissionService {
    public function permissions () {
        try {
            $can = Gate::check(PermissionsEnum::CAN_MANAGE_PERMISSION['slug']);

            if(!$can) {
                throw new Exception('У вас нет прав для запроса разрешений', 403);
            }

            $permissions = Permission::all();

            return PermissionResource::collection($permissions);
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }
}
