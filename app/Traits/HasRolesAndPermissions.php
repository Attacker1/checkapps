<?php


namespace App\Traits;

use App\Models\Role;

trait HasRolesAndPermissions
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function hasRole($checkRole)
    {
        $role = $this->role()->first();

        if(!$role) {
            return false;
        }

        return $role->slug === $checkRole;
    }
}
