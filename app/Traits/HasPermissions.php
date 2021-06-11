<?php


namespace App\Traits;

use App\Models\Permission;

trait HasPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission(String $permission): bool
    {
        return (bool) $this->permissions->where('slug', $permission)->count();
    }

    /**
     * @param mixed $permissions
     * @return bool
     */
    public function hasPermissions($permissions): bool
    {
        $permissions = is_array($permissions) ? $permissions : explode(',', $permissions);

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $permissions
     * @return mixed
     */
    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    /**
     * @param mixed $permissions
     * @return $this
     */
    public function givePermissionsTo($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : explode(',', $permissions);
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * @param mixed $permissions
     * @return HasPermissions
     */
    public function refreshPermissions($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : explode(',', $permissions);
        
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}
