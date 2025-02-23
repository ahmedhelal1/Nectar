<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'quantity',
        'category_id',

    ];
    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }
}
