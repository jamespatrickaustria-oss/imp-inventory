<?php

namespace App\Services;

use App\Models\products;
use Livewire\WithPagination;

class ProductService
{
    use WithPagination;
    
    protected $lowStockNotificationService;
    protected $stockMovementService;

    public function __construct(
        LowStockNotificationService $lowStockNotificationService = null,
        StockMovementService $stockMovementService = null
    ) {
        // Make low stock notification service optional for backward compatibility
        $this->lowStockNotificationService = $lowStockNotificationService ?? app(LowStockNotificationService::class);
        $this->stockMovementService = $stockMovementService ?? app(StockMovementService::class);
    }
    
    public function getAll($search = null, $includeArchived = false) {
        $query = products::with('category');
        
        if (!$includeArchived) {
            $query->whereNull('deleted_at');
        }
        
        return $query->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%");
            })->latest()->paginate(5);
    }

    public function calculateStockPercentage($total, $lowStock){
        if ($total <= 0) return 0;
    
        $percentage = (($total - $lowStock) / $total) * 100;
        return number_format($percentage, 0);
    }


    public function getAllCount() {
        return products::whereNull('deleted_at')->count();
    }

    public function getRevenue(){
            $totalRevenueLastMonth = products::where('created_at', '>=', now()->subDays(30))->whereNull('deleted_at')->sum('price');
        return $totalRevenueLastMonth;
       
    }

    public function store(array $data) {
        $product = products::create($data);
        
        // Check if newly created product has low stock
        if ($product && $this->lowStockNotificationService) {
            $this->lowStockNotificationService->checkAndNotify($product);
        }
        
        return $product;
    }

    public function update($id, array $data) {
        $product = products::whereNull('deleted_at')->findOrFail($id);
        $oldQuantity = $product->quantity;
        
        $result = $product->update($data);
        
        // Log stock movement if quantity changed
        if ($result && isset($data['quantity'])) {
            $newQuantity = $data['quantity'];
            $quantityDifference = $newQuantity - $oldQuantity;
            
            if ($quantityDifference !== 0 && $this->stockMovementService) {
                $movementType = $quantityDifference > 0 ? 'stock_in' : 'stock_out';
                $this->stockMovementService->logMovement(
                    $id,
                    $movementType,
                    abs($quantityDifference),
                    'Manual product update',
                    null,
                    'manual',
                    auth()->id()
                );
            }
        }
        
        // Check for low stock after update
        if ($result && $this->lowStockNotificationService) {
            $updatedProduct = products::find($id);
            $this->lowStockNotificationService->checkAndNotify($updatedProduct);
        }
        
        return $result;
    }

    public function delete($id) {
        return products::whereNull('deleted_at')->findOrFail($id)->delete();
    }

    public function archive($id) {
        return products::whereNull('deleted_at')->findOrFail($id)->delete();
    }

    public function restore($id) {
        return products::withTrashed()->findOrFail($id)->restore();
    }

    public function permanentDelete($id) {
        $product = products::withTrashed()->findOrFail($id);
        return $product->forceDelete();
    }

    public function getArchived($search = null) {
        return products::with('category')
            ->onlyTrashed()
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%");
            })->latest()->paginate(5);
    }

    public function getLowStock() {
        // S-tariqa l-as-hal:
        return products::whereRaw('quantity <= min_stock')->whereNull('deleted_at')->latest()->get();
    }

    public function getLowStockCount() {
        // S-tariqa l-as-hal:
        return products::whereRaw('quantity <= min_stock')->whereNull('deleted_at')->count();
    }
}
