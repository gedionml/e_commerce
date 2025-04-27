<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function reviews() { return $this->hasMany(\App\Models\Review::class); }
    public function productImages() { return $this->hasMany(\App\Models\ProductImage::class); }
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'category',
    ];
    use HasFactory;

}
