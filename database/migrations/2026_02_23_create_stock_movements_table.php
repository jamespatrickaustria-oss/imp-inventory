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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->enum('movement_type', ['stock_in', 'stock_out'])->comment('Type of stock movement');
            $table->integer('quantity')->comment('Quantity added or removed');
            $table->text('reason')->nullable()->comment('Reason for stock movement');
            $table->string('reference_id')->nullable()->comment('Reference ID (e.g., Order ID, Purchase ID)');
            $table->string('reference_type')->nullable()->comment('Type of reference (e.g., order, purchase, manual)');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->comment('User who made the movement');
            $table->timestamps();
            
            // Add indexes for better query performance
            $table->index('product_id');
            $table->index('movement_type');
            $table->index('created_at');
            $table->index(['product_id', 'created_at']);
            $table->index(['movement_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
