<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class categories extends Model 
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'image_path'];

    
    public function products(): HasMany
    {
        return $this->hasMany(products::class, 'category_id'); 
    }
}