<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_permissions');
    }
}
