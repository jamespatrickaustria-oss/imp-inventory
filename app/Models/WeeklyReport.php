<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    protected $fillable = [
        'report_date',
        'week_start',
        'week_end',
        'total_products',
        'low_stock_count',
        'out_of_stock_count',
        'total_inventory_value',
        'orders_count',
        'revenue',
        'top_products',
        'low_stock_products',
        'report_data',
        'sent_to',
        'sent_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'week_start' => 'date',
        'week_end' => 'date',
        'top_products' => 'array',
        'low_stock_products' => 'array',
        'report_data' => 'array',
        'sent_at' => 'datetime',
    ];
}
