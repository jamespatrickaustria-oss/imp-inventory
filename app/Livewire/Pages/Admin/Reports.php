<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\WeeklyReportService;
use Carbon\Carbon;

class Reports extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $sortBy = 'report_date';
    public $sortOrder = 'desc';

    public function mount()
    {
        // Set default date range (last 3 months)
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->startDate = Carbon::now()->subMonths(3)->format('Y-m-d');
    }

    public function updated($field)
    {
        // Reset pagination when filters change
        if (in_array($field, ['startDate', 'endDate', 'sortBy', 'sortOrder'])) {
            $this->resetPage();
        }
    }

    public function generateReports(WeeklyReportService $weeklyReportService)
    {
        // Validate dates
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->mount();
        $this->resetPage();
    }

    public function exportAsCSV(WeeklyReportService $weeklyReportService)
    {
        $data = $weeklyReportService->exportReports(
            $this->startDate,
            $this->endDate,
            [
                'sortBy' => $this->sortBy,
                'sortOrder' => $this->sortOrder,
            ]
        );

        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $filename = 'weekly_reports_' . date('Y-m-d_His') . '.csv';

        $headers = array(
            "Content-type" => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = ['Report Date', 'Week Start', 'Week End', 'Total Products', 'Low Stock', 'Out of Stock', 'Inventory Value', 'Sent At'];

        $callback = function () use ($data, $columns, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            // Add export metadata header
            fputcsv($file, ['Weekly Reports Export']);
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

    public function render(WeeklyReportService $weeklyReportService)
    {
        return view('livewire.pages.admin.reports', [
            'latestReport' => $weeklyReportService->getLatestReport(),
            'reports' => $weeklyReportService->getReportsInRange($this->startDate, $this->endDate, [
                'sortBy' => $this->sortBy,
                'sortOrder' => $this->sortOrder,
            ]),
        ])->layout('layouts.admin');
    }
}
