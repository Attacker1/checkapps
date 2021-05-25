<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
