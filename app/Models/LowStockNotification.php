<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowStockNotification extends Model
{
    protected $fillable = [
        'product_id',
        'quantity_when_notified',
        'notified_at',
        'is_active',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(products::class);
    }
}
