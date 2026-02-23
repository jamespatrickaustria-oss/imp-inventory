<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'sku', 'quantity', 
        'price', 'image_path', 'min_stock'
    ];

    public function Category(){
        return $this->belongsTo(categories::class);
    }

    public function isLowStock(){
        return $this->quantity <= $this->min_stock;
    }
}
