<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'city_id',
        'governorate_id',
    ];

    public function cities()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    public function governorates()
    {
        return $this->belongsTo(Governorates::class, 'governorate_id');
    }
}
