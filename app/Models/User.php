<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_fio',
        'user_email',
        'user_phone',
        'referer_user_id',
        'referer_user_fio',
        'career_id',
        'token_id'
    ];

    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
