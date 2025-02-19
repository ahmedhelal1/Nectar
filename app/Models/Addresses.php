<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    public function cities()
    {
        return $this->hasMany(Cities::class, 'city_id');
    }
    public function governorates()
    {
        return $this->hasMany(Governorates::class, 'governorate_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
