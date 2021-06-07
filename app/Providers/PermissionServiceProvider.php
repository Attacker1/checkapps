<?php

namespace App\Providers;

use App\Models\Permission;
use App\Enum\PermissionsEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $permissions = collect(PermissionsEnum::values());

            $permissions->map(function ($permission) {
                Gate::define($permission['slug'], function ($user) use ($permission) {
                    return $user->hasPermission($permission['slug']);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
        return true;
    }
}
