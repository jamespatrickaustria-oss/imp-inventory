<?php

namespace App\Console\Commands;

use App\Services\WeeklyReportService;
use Illuminate\Console\Command;

class GenerateWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:weekly {--send : Send report via email} {--date= : Report date (YYYY-MM-DD format)}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Generate weekly inventory and sales report';

    /**
     * Execute the console command.
     */
    public function handle(WeeklyReportService $reportService): int
    {
        $sendReport = $this->option('send');
        $dateString = $this->option('date');

        try {
            // Parse the date if provided
            $date = null;
            if ($dateString) {
                $date = \Carbon\Carbon::createFromFormat('Y-m-d', $dateString);
            }

            $this->info('Generating weekly report...');
            
            if ($sendReport) {
                $success = $reportService->generateAndSendWeeklyReport($date);
                if ($success) {
                    $this->info('✅ Weekly report generated and sent successfully!');
                    return Command::SUCCESS;
                } else {
                    $this->error('❌ Failed to generate and send report');
                    return Command::FAILURE;
                }
            } else {
                $report = $reportService->generateWeeklyReport($date);
                if ($report) {
                    $this->info('✅ Weekly report generated successfully!');
                    $this->printReportSummary($report);
                    $this->warn('Run with --send option to email the report');
                    return Command::SUCCESS;
                } else {
                    $this->error('❌ Failed to generate report');
                    return Command::FAILURE;
                }
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Print report summary to console
     */
    protected function printReportSummary($report): void
    {
        $this->newLine();
        $this->info('=== Weekly Report Summary ===');
        $this->line("Report Date: {$report->report_date}");
        $this->line("Week: {$report->week_start} to {$report->week_end}");
        $this->newLine();
        
        $this->line("Total Products: {$report->total_products}");
        $this->line("Low Stock Items: {$report->low_stock_count}");
        $this->line("Out of Stock: {$report->out_of_stock_count}");
        $this->line("Total Inventory Value: \${$report->total_inventory_value}");
        $this->newLine();
        
        $this->line("Orders This Week: {$report->orders_count}");
        $this->line("Revenue: \${$report->revenue}");
        $this->newLine();

        if (!empty($report->top_products)) {
            $this->info('Top 5 Products:');
            foreach ($report->top_products as $product) {
                $this->line("  • {$product['name']} - {$product['total_sold']} sold (\${$product['revenue']})");
            }
        }
    }
}
