<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'value',
    ];

    public function scopeSettingBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
