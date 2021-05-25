<?php


namespace App\Traits;

use App\Models\Role;

trait HasRolesAndPermissions
{
    public function role()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function getRole(string $role)
    {
        return Role::where('slug', $role)->get();
    }

    public function setRole(string $role)
    {
        $newRole = $this->getRole($role)->first();

        if ($newRole === null) {
            return $this;
        }

        $this->role()->save($newRole);
        return $this;
    }

    // public function hasRole($role)
    // {
    //     if ($this->role->contains('slug', $role)) {
    //         return true;
    //     }

    //     return false;
    // }
}
