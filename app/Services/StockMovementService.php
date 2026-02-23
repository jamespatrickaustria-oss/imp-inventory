<?php

namespace App\Services;

use App\Models\StockMovement;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class StockMovementService
{
    /**
     * Log a stock movement
     */
    public function logMovement(
        $productId,
        $movementType,
        $quantity,
        $reason = null,
        $referenceId = null,
        $referenceType = null,
        $userId = null
    ) {
        if ($userId === null) {
            $userId = auth()->id();
        }

        return StockMovement::create([
            'product_id' => $productId,
            'movement_type' => $movementType,
            'quantity' => $quantity,
            'reason' => $reason,
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'user_id' => $userId,
        ]);
    }

    /**
     * Log stock in (add stock)
     */
    public function logStockIn(
        $productId,
        $quantity,
        $reason = null,
        $referenceId = null,
        $referenceType = null,
        $userId = null
    ) {
        return $this->logMovement(
            $productId,
            'stock_in',
            $quantity,
            $reason,
            $referenceId,
            $referenceType,
            $userId
        );
    }

    /**
     * Log stock out (reduce stock)
     */
    public function logStockOut(
        $productId,
        $quantity,
        $reason = null,
        $referenceId = null,
        $referenceType = null,
        $userId = null
    ) {
        return $this->logMovement(
            $productId,
            'stock_out',
            $quantity,
            $reason,
            $referenceId,
            $referenceType,
            $userId
        );
    }

    /**
     * Get stock movements within a date range
     */
    public function getMovementsInRange($startDate, $endDate, $filters = [])
    {
        $query = StockMovement::query()
            ->with('product', 'user')
            ->withinDateRange($startDate, $endDate);

        // Filter by movement type if provided
        if (isset($filters['movement_type']) && $filters['movement_type']) {
            $query->where('movement_type', $filters['movement_type']);
        }

        // Filter by product if provided
        if (isset($filters['product_id']) && $filters['product_id']) {
            $query->where('product_id', $filters['product_id']);
        }

        // Filter by reference type if provided
        if (isset($filters['reference_type']) && $filters['reference_type']) {
            $query->where('reference_type', $filters['reference_type']);
        }

        // Order by date descending (latest first)
        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Get movements summary by product within a date range
     */
    public function getMovementsSummaryByProduct($startDate, $endDate, $filters = [])
    {
        $query = StockMovement::query()
            ->with('product')
            ->withinDateRange($startDate, $endDate);

        // Apply filters
        if (isset($filters['movement_type']) && $filters['movement_type']) {
            $query->where('movement_type', $filters['movement_type']);
        }

        if (isset($filters['product_id']) && $filters['product_id']) {
            $query->where('product_id', $filters['product_id']);
        }

        $movements = $query->get();

        $summary = [];

        foreach ($movements as $movement) {
            $productId = $movement->product_id;
            $productName = $movement->product->name ?? 'Unknown Product';

            if (!isset($summary[$productId])) {
                $summary[$productId] = [
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'sku' => $movement->product->sku ?? 'N/A',
                    'total_in' => 0,
                    'total_out' => 0,
                    'net_change' => 0,
                    'movements_count' => 0,
                ];
            }

            if ($movement->isStockIn()) {
                $summary[$productId]['total_in'] += $movement->quantity;
            } else {
                $summary[$productId]['total_out'] += $movement->quantity;
            }

            $summary[$productId]['movements_count']++;
        }

        // Calculate net change
        foreach ($summary as &$item) {
            $item['net_change'] = $item['total_in'] - $item['total_out'];
        }

        // Sort by product name
        usort($summary, function ($a, $b) {
            return strcmp($a['product_name'], $b['product_name']);
        });

        return $summary;
    }

    /**
     * Get detailed report for a date range
     */
    public function getDetailedReport($startDate, $endDate, $filters = [])
    {
        $movements = $this->getMovementsInRange($startDate, $endDate, $filters);
        $summary = $this->getMovementsSummaryByProduct($startDate, $endDate, $filters);

        // Calculate totals from the filtered summary
        $totals = [
            'total_stock_in' => 0,
            'total_stock_out' => 0,
            'total_quantity_in' => 0,
            'total_quantity_out' => 0,
            'total_movements' => 0,
        ];

        foreach ($summary as $item) {
            if ($item['total_in'] > 0) {
                $totals['total_stock_in']++;
                $totals['total_quantity_in'] += $item['total_in'];
            }
            if ($item['total_out'] > 0) {
                $totals['total_stock_out']++;
                $totals['total_quantity_out'] += $item['total_out'];
            }
            $totals['total_movements'] += $item['movements_count'];
        }

        return [
            'movements' => $movements,
            'summary' => $summary,
            'totals' => $totals,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    /**
     * Get movement statistics for a date range
     */
    public function getStatistics($startDate, $endDate)
    {
        $movements = StockMovement::withDate('created_at', $startDate, $endDate)->get();

        return [
            'total_movements' => $movements->count(),
            'total_stock_in' => $movements->where('movement_type', 'stock_in')->count(),
            'total_stock_out' => $movements->where('movement_type', 'stock_out')->count(),
            'total_quantity_in' => $movements->where('movement_type', 'stock_in')->sum('quantity'),
            'total_quantity_out' => $movements->where('movement_type', 'stock_out')->sum('quantity'),
            'affected_products' => $movements->pluck('product_id')->unique()->count(),
        ];
    }

    /**
     * Export movements to array (for CSV/Excel)
     */
    public function exportMovements($startDate, $endDate, $filters = [])
    {
        $movements = StockMovement::query()
            ->with('product', 'user')
            ->withinDateRange($startDate, $endDate);

        // Apply filters
        if (isset($filters['movement_type']) && $filters['movement_type']) {
            $movements->where('movement_type', $filters['movement_type']);
        }

        if (isset($filters['product_id']) && $filters['product_id']) {
            $movements->where('product_id', $filters['product_id']);
        }

        $data = $movements->orderBy('created_at', 'desc')->get()->map(function ($movement) {
            return [
                'Date' => $movement->created_at->format('Y-m-d H:i:s'),
                'Product' => $movement->product->name ?? 'Unknown',
                'SKU' => $movement->product->sku ?? 'N/A',
                'Movement Type' => $movement->getFormattedTypeAttribute(),
                'Quantity' => $movement->quantity,
                'Reason' => $movement->reason ?? 'N/A',
                'Reference ID' => $movement->reference_id ?? 'N/A',
                'Reference Type' => $movement->reference_type ?? 'N/A',
                'Made By' => $movement->user->name ?? 'System',
            ];
        });

        return $data;
    }

    /**
     * Query scope helper - filter by date range
     */
    private function withDate($column, $startDate, $endDate)
    {
        return StockMovement::query()
            ->whereDate($column, '>=', $startDate)
            ->whereDate($column, '<=', $endDate);
    }
}
