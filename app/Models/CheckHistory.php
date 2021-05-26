<?php

namespace App\Models;

use App\Models\User;
use App\Models\Check;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_id',
        'status',
        'comment',
        'reward',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function check()
    {
        return $this->belongsTo(Check::class);
    }
}
