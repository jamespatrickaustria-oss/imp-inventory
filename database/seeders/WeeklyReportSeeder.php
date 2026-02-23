<?php

namespace Database\Seeders;

use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeeklyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 12 weeks of sample data (3 months)
        $now = Carbon::now();
        $startDate = $now->clone()->subWeeks(11);

        for ($i = 0; $i < 12; $i++) {
            $weekStart = $startDate->clone()->addWeeks($i)->startOfWeek();
            $weekEnd = $weekStart->clone()->endOfWeek();
            $reportDate = $weekEnd->clone();

            WeeklyReport::create([
                'report_date' => $reportDate,
                'week_start' => $weekStart,
                'week_end' => $weekEnd,
                'total_products' => rand(45, 75),
                'low_stock_count' => rand(3, 12),
                'out_of_stock_count' => rand(0, 5),
                'total_inventory_value' => rand(15000, 50000),
                'orders_count' => rand(8, 35),
                'revenue' => rand(500, 10000),
                'top_products' => $this->generateTopProducts(),
                'low_stock_products' => $this->generateLowStockProducts(),
                'report_data' => $this->generateReportData(),
                'sent_at' => rand(0, 1) ? $reportDate->copy()->addHours(rand(1, 24)) : null,
            ]);
        }

        echo "✅ Generated 12 weeks of sample weekly reports.\n";
    }

    private function generateTopProducts(): array
    {
        return [
            [
                'id' => rand(1, 100),
                'name' => 'Sample Product ' . rand(1, 50),
                'quantity_sold' => rand(5, 50),
                'revenue' => rand(100, 1000),
            ],
            [
                'id' => rand(1, 100),
                'name' => 'Sample Product ' . rand(1, 50),
                'quantity_sold' => rand(5, 50),
                'revenue' => rand(100, 1000),
            ],
            [
                'id' => rand(1, 100),
                'name' => 'Sample Product ' . rand(1, 50),
                'quantity_sold' => rand(5, 50),
                'revenue' => rand(100, 1000),
            ],
        ];
    }

    private function generateLowStockProducts(): array
    {
        return [
            [
                'id' => rand(1, 100),
                'name' => 'Low Stock Product ' . rand(1, 30),
                'current_stock' => rand(1, 5),
                'min_stock' => 10,
            ],
            [
                'id' => rand(1, 100),
                'name' => 'Low Stock Product ' . rand(1, 30),
                'current_stock' => rand(1, 5),
                'min_stock' => 10,
            ],
        ];
    }

    private function generateReportData(): array
    {
        return [
            'summary' => [
                'total_products' => rand(45, 75),
                'active_inventory' => rand(250, 500),
                'processed_orders' => rand(8, 35),
            ],
            'metrics' => [
                'inventory_turnover' => round(rand(10, 50) / 10, 2),
                'order_fulfillment_rate' => round(rand(85, 100), 2),
                'average_order_value' => round(rand(50, 500), 2),
            ],
        ];
    }
}
