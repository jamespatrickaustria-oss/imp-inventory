<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $table = 'stock_movements';

    protected $fillable = [
        'product_id',
        'movement_type',
        'quantity',
        'reason',
        'reference_id',
        'reference_type',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product associated with this stock movement
     */
    public function product()
    {
        return $this->belongsTo(products::class);
    }

    /**
     * Get the user who made this movement
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is a stock in movement
     */
    public function isStockIn()
    {
        return $this->movement_type === 'stock_in';
    }

    /**
     * Check if this is a stock out movement
     */
    public function isStockOut()
    {
        return $this->movement_type === 'stock_out';
    }

    /**
     * Scope: Get movements within a date range
     */
    public function scopeWithinDateRange($query, $startDate, $endDate)
    {
        return $query->whereDate('created_at', '>=', $startDate)
                     ->whereDate('created_at', '<=', $endDate);
    }

    /**
     * Scope: Get only stock in movements
     */
    public function scopeStockIn($query)
    {
        return $query->where('movement_type', 'stock_in');
    }

    /**
     * Scope: Get only stock out movements
     */
    public function scopeStockOut($query)
    {
        return $query->where('movement_type', 'stock_out');
    }

    /**
     * Scope: Get movements for a specific product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope: Get movements by reference type
     */
    public function scopeByReferenceType($query, $referenceType)
    {
        return $query->where('reference_type', $referenceType);
    }

    /**
     * Get formatted movement type
     */
    public function getFormattedTypeAttribute()
    {
        return $this->movement_type === 'stock_in' ? 'Stock In' : 'Stock Out';
    }
}
