<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Products extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category_id',

    ];
    public function categories()
    {
        return $this->belongsTo(Categories::class, "category_id");
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')->useDisk('public');
    }
}
