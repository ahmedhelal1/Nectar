<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Categories extends Model
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'image',

    ];

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
