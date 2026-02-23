<?php

namespace App\Services;

use App\Models\products;
use App\Models\orders;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WeeklyReportService
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Generate a weekly report for the past week
     *
     * @param \DateTime|null $endDate End date for the week (default: today)
     * @return WeeklyReport|null
     */
    public function generateWeeklyReport($endDate = null): ?WeeklyReport
    {
        try {
            $endDate = $endDate ? Carbon::parse($endDate) : Carbon::now();
            $weekStart = $endDate->clone()->startOfWeek();
            $weekEnd = $endDate->clone()->endOfWeek();

            // Get all report data
            $reportData = $this->collectReportData($weekStart, $weekEnd);

            // Create the report record
            $report = WeeklyReport::create([
                'report_date' => $endDate,
                'week_start' => $weekStart,
                'week_end' => $weekEnd,
                'total_products' => $reportData['total_products'],
                'low_stock_count' => $reportData['low_stock_count'],
                'out_of_stock_count' => $reportData['out_of_stock_count'],
                'total_inventory_value' => $reportData['total_inventory_value'],
                'orders_count' => $reportData['orders_count'],
                'revenue' => $reportData['revenue'],
                'top_products' => $reportData['top_products'],
                'low_stock_products' => $reportData['low_stock_products'],
                'report_data' => $reportData,
            ]);

            Log::info("Weekly report generated successfully for week {$weekStart} to {$weekEnd}");
            return $report;

        } catch (\Exception $e) {
            Log::error("Error generating weekly report: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all reports
     */
    public function getAllReports()
    {
        return WeeklyReport::orderBy('report_date', 'desc')->paginate(15);
    }

    /**
     * Get latest report
     */
    public function getLatestReport()
    {
        return WeeklyReport::orderBy('report_date', 'desc')->first();
    }

    /**
     * Get reports within a date range
     */
    public function getReportsInRange($startDate, $endDate, $options = [])
    {
        $sortBy = $options['sortBy'] ?? 'report_date';
        $sortOrder = $options['sortOrder'] ?? 'desc';

        $query = WeeklyReport::query()
            ->whereDate('report_date', '>=', $startDate)
            ->whereDate('report_date', '<=', $endDate);

        // Apply sorting
        if (in_array($sortBy, ['report_date', 'total_inventory_value', 'low_stock_count'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('report_date', 'desc');
        }

        return $query->paginate(15);
    }

    /**
     * Collect all data needed for the weekly report
     *
     * @param Carbon $weekStart
     * @param Carbon $weekEnd
     * @return array
     */
    protected function collectReportData(Carbon $weekStart, Carbon $weekEnd): array
    {
        return [
            'total_products' => $this->getTotalProducts(),
            'low_stock_count' => $this->getLowStockCount(),
            'out_of_stock_count' => $this->getOutOfStockCount(),
            'total_inventory_value' => $this->getTotalInventoryValue(),
            'orders_count' => $this->getOrdersCount($weekStart, $weekEnd),
            'revenue' => $this->getRevenue($weekStart, $weekEnd),
            'top_products' => $this->getTopProducts($weekStart, $weekEnd),
            'low_stock_products' => $this->getLowStockProducts(),
            'product_categories' => $this->getProductsByCategory(),
            'stock_movement' => $this->getStockMovement($weekStart, $weekEnd),
        ];
    }

    /**
     * Get total active products
     */
    protected function getTotalProducts(): int
    {
        return products::whereNull('deleted_at')->count();
    }

    /**
     * Get count of low stock products
     */
    protected function getLowStockCount(): int
    {
        return products::whereRaw('quantity <= min_stock')
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Get count of out of stock products
     */
    protected function getOutOfStockCount(): int
    {
        return products::where('quantity', '=', 0)
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Calculate total inventory value
     */
    protected function getTotalInventoryValue(): float
    {
        return (float) products::whereNull('deleted_at')
            ->selectRaw('SUM(quantity * price) as total_value')
            ->value('total_value') ?? 0;
    }

    /**
     * Get orders count for the week
     */
    protected function getOrdersCount(Carbon $weekStart, Carbon $weekEnd): int
    {
        return orders::whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();
    }

    /**
     * Get revenue for the week
     */
    protected function getRevenue(Carbon $weekStart, Carbon $weekEnd): float
    {
        return (float) orders::whereBetween('created_at', [$weekStart, $weekEnd])
            ->sum('total_amount') ?? 0;
    }

    /**
     * Get top 5 selling products
     */
    protected function getTopProducts(Carbon $weekStart, Carbon $weekEnd): array
    {
        $topProducts = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$weekStart, $weekEnd])
            ->selectRaw('products.id, products.name, products.sku, products.price, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('products.id', 'products.name', 'products.sku', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'price' => $item->price,
                    'total_sold' => $item->total_sold,
                    'revenue' => $item->revenue,
                ];
            })
            ->toArray();

        return $topProducts;
    }

    /**
     * Get low stock products for the report
     */
    protected function getLowStockProducts(): array
    {
        return products::whereRaw('quantity <= min_stock')
            ->whereNull('deleted_at')
            ->with('category')
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $product->quantity,
                    'min_stock' => $product->min_stock,
                    'category' => $product->category?->name ?? 'N/A',
                ];
            })
            ->toArray();
    }

    /**
     * Get products grouped by category
     */
    protected function getProductsByCategory(): array
    {
        return \DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereNull('products.deleted_at')
            ->selectRaw('categories.name as category, COUNT(products.id) as product_count, SUM(products.quantity * products.price) as inventory_value')
            ->groupBy('categories.id', 'categories.name')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category,
                    'product_count' => $item->product_count,
                    'inventory_value' => $item->inventory_value,
                ];
            })
            ->toArray();
    }

    /**
     * Get stock movement (products with significant quantity changes)
     */
    protected function getStockMovement(Carbon $weekStart, Carbon $weekEnd): array
    {
        return products::whereRaw('updated_at BETWEEN ? AND ?', [$weekStart, $weekEnd])
            ->whereNull('deleted_at')
            ->latest('updated_at')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'current_quantity' => $product->quantity,
                    'last_updated' => $product->updated_at->toString(),
                ];
            })
            ->toArray();
    }

    /**
     * Send the weekly report via email
     *
     * @param WeeklyReport $report
     * @return bool
     */
    public function sendReport(WeeklyReport $report): bool
    {
        try {
            $adminEmails = $this->getAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('No admin email addresses configured for weekly reports');
                return false;
            }

            $sent = $this->emailService->sendWeeklyReport($report, $adminEmails);

            if ($sent) {
                $report->update([
                    'sent_to' => implode(',', $adminEmails),
                    'sent_at' => now(),
                ]);
                
                Log::info("Weekly report sent to: " . implode(', ', $adminEmails));
            }

            return $sent;

        } catch (\Exception $e) {
            Log::error("Error sending weekly report: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate and send weekly report in one go
     */
    public function generateAndSendWeeklyReport($endDate = null): bool
    {
        $report = $this->generateWeeklyReport($endDate);

        if (!$report) {
            return false;
        }

        return $this->sendReport($report);
    }

    /**
     * Get admin email addresses
     */
    protected function getAdminEmails(): array
    {
        $emails = [];
        
        $adminEmail = env('ADMIN_EMAIL');
        if ($adminEmail) {
            $emails[] = $adminEmail;
        }
        
        $fromEmail = env('MAIL_FROM_ADDRESS');
        if ($fromEmail && !in_array($fromEmail, $emails)) {
            $emails[] = $fromEmail;
        }

        return $emails;
    }

    /**
     * Get report for specific week
     */
    public function getReportForWeek(Carbon $date)
    {
        $weekStart = $date->clone()->startOfWeek();
        $weekEnd = $date->clone()->endOfWeek();

        return WeeklyReport::whereBetween('week_start', [$weekStart, $weekEnd])->first();
    }

    /**
     * Export reports to array for CSV/Excel
     */
    public function exportReports($startDate, $endDate, $options = [])
    {
        $sortBy = $options['sortBy'] ?? 'report_date';
        $sortOrder = $options['sortOrder'] ?? 'desc';

        $query = WeeklyReport::query()
            ->whereDate('report_date', '>=', $startDate)
            ->whereDate('report_date', '<=', $endDate);

        // Apply sorting
        if (in_array($sortBy, ['report_date', 'total_inventory_value', 'low_stock_count'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('report_date', 'desc');
        }

        $reports = $query->get();

        $data = $reports->map(function ($report) {
            return [
                'Report Date' => optional($report->report_date)->format('Y-m-d'),
                'Week Start' => optional($report->week_start)->format('Y-m-d'),
                'Week End' => optional($report->week_end)->format('Y-m-d'),
                'Total Products' => $report->total_products,
                'Low Stock' => $report->low_stock_count,
                'Out of Stock' => $report->out_of_stock_count,
                'Inventory Value' => '$' . number_format($report->total_inventory_value, 2),
                'Sent At' => optional($report->sent_at)->format('Y-m-d H:i:s') ?? 'Not Sent',
            ];
        });

        return $data;
    }
}
