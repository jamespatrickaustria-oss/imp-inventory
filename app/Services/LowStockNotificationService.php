<?php

namespace App\Services;

use App\Models\products;
use App\Models\LowStockNotification;
use Illuminate\Support\Facades\Log;

class LowStockNotificationService
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Check if a product's stock has reached the low-stock threshold
     * and send notification if not already sent
     *
     * @param products $product
     * @return bool
     */
    public function checkAndNotify(products $product): bool
    {
        try {
            // Check if quantity is at or below min_stock threshold
            if ($product->quantity <= $product->min_stock) {
                // Check if we already have an active notification for this product
                $existingNotification = LowStockNotification::where('product_id', $product->id)
                    ->where('is_active', true)
                    ->first();

                // Only send if no active notification exists
                if (!$existingNotification) {
                    $sent = $this->emailService->sendLowStockNotification($product);
                    
                    if ($sent) {
                        // Record that we've notified about this low stock event
                        LowStockNotification::create([
                            'product_id' => $product->id,
                            'quantity_when_notified' => $product->quantity,
                            'is_active' => true,
                        ]);

                        Log::info("Low stock notification sent for product: {$product->name} (ID: {$product->id})");
                        return true;
                    }
                }
            } else {
                // Stock is above threshold, mark any active notifications as inactive
                LowStockNotification::where('product_id', $product->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }

            return false;
        } catch (\Exception $e) {
            Log::error("Error in low stock notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all products currently in low stock
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLowStockProducts()
    {
        return products::with('category')
            ->whereRaw('quantity <= min_stock')
            ->whereNull('deleted_at')
            ->latest()
            ->get();
    }

    /**
     * Get all active low stock notifications
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveNotifications()
    {
        return LowStockNotification::with('product')
            ->where('is_active', true)
            ->latest()
            ->get();
    }
}
