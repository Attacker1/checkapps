<?php

namespace App\Models;

use App\Models\CheckHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Check extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_id',
        'image',
        'amount',
        'amount_in_currency',
        'dt',
        'dt_purchase',
        'currency',
        'verify_quantity',
        'current_quantity',
        'status',
        'check_user_id',
    ];

    public function checkHistory()
    {
        return $this->hasMany(CheckHistory::class);
    }
}
