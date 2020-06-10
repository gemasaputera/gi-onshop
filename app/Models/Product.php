<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'categories_id','name','slug','description','price','quantity',
    ];
    protected $hidden = [
    ];

    public function galleries() {
        return $this->hasMany(ProductGallery::class, 'products_id');
    }

    public function categories() {
        return $this->belongsTo(Category::class, 'categories_id','id');
    }
}
