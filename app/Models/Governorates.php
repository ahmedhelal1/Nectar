<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorates extends Model
{
    use HasFactory;
    public function cities()
    {
        return $this->hasMany(Cities::class, 'governorate_id');
    }
}
