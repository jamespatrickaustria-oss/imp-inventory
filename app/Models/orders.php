<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    public function items(){
        return $this->hasMany(products::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
