<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->date('week_start');
            $table->date('week_end');
            $table->integer('total_products');
            $table->integer('low_stock_count');
            $table->integer('out_of_stock_count');
            $table->decimal('total_inventory_value', 15, 2)->default(0);
            $table->integer('orders_count');
            $table->decimal('revenue', 15, 2)->default(0);
            $table->json('top_products')->nullable(); // JSON array of top selling products
            $table->json('low_stock_products')->nullable(); // JSON array of low stock products
            $table->json('report_data')->nullable(); // Full report data
            $table->text('sent_to')->nullable(); // CSV of email addresses report was sent to
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index('report_date');
            $table->index('week_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
