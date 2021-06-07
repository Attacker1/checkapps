<?php

namespace App\Models;

use App\Enum\CheckHistoryStatusEnum;
use App\Models\CheckHistory;
use Laravel\Passport\HasApiTokens;
use App\Traits\HasPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasPermissions;

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
        'token_id',
        'password',
    ];

    public function checkHistory()
    {
        return $this->hasMany(CheckHistory::class, 'user_id', 'user_id');
    }

    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTokenId($query, $tokenId)
    {
        return $query->where('token_id', $tokenId);
    }

    public function scopeByEmail($query, $email)
    {
        return $query->where('user_email', $email);
    }

    public function rejectedChecks() {
        return $this->checkHistory()->where('status', CheckHistoryStatusEnum::REJECTED);
    }

    public function approvedChecks() {
        return $this->checkHistory()->where('status', CheckHistoryStatusEnum::APPROVED);
    }
}
