<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\StockMovementService;
use App\Models\products;
use Carbon\Carbon;

class StockMovementReport extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $movementType = '';
    public $productId = '';
    public $showSummary = true;
    public $showDetails = true;

    protected $listeners = ['resetFilters'];

    public function updated($field)
    {
        // Reset pagination when filters change
        if (in_array($field, ['movementType', 'productId'])) {
            $this->resetPage();
        }
    }

    public function mount()
    {
        // Set default date range (current month)
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function generateReport(StockMovementService $stockMovementService)
    {
        // Validate dates
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        // Return to first page on new search
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->movementType = '';
        $this->productId = '';
        $this->resetPage();
    }

    public function exportAsCSV(StockMovementService $stockMovementService)
    {
        $filters = [
            'movement_type' => $this->movementType,
            'product_id' => $this->productId,
        ];

        $data = $stockMovementService->exportMovements(
            $this->startDate,
            $this->endDate,
            $filters
        );

        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $filename = 'stock_movement_report_' . date('Y-m-d_His') . '.csv';

        $headers = array(
            "Content-type" => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = ['Date', 'Product', 'SKU', 'Movement Type', 'Quantity', 'Reason', 'Reference ID', 'Reference Type', 'Made By'];

        $callback = function () use ($data, $columns, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            // Add export metadata header
            fputcsv($file, ['Stock Movement Report Export']);
            fputcsv($file, ['Date Range: ' . $startDate . ' to ' . $endDate]);
            fputcsv($file, ['Export Date: ' . date('Y-m-d H:i:s')]);
            fputcsv($file, []); // Empty row for readability
            fputcsv($file, $columns);

            foreach ($data as $row) {
                fputcsv($file, (array)$row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render(StockMovementService $stockMovementService)
    {
        $filters = [
            'movement_type' => $this->movementType,
            'product_id' => $this->productId,
        ];

        $reportData = $stockMovementService->getDetailedReport(
            $this->startDate,
            $this->endDate,
            $filters
        );

        $products = products::whereNull('deleted_at')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        return view('livewire.pages.admin.stock-movement-report', [
            'movements' => $reportData['movements'],
            'summary' => $reportData['summary'],
            'totals' => $reportData['totals'],
            'products' => $products,
        ])->layout('layouts.admin');
    }
}
