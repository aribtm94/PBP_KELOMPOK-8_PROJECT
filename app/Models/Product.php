<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','category_id','price','stock',
        'image_path','is_active','description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'integer',
        'stock'     => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
