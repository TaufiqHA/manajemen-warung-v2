<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'warung_id',
        'category_id',
        'name',
        'description',
        'price',
        'order',
        'stock',
        'unit',
        'image_url',
        'is_active',
    ];

    public function warung()
    {
        return $this->belongsTo(Warung::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
