# Weekly Report Feature Documentation

## Overview

The Weekly Report feature automatically generates and sends comprehensive weekly inventory and sales reports to administrators. It provides crucial business intelligence including stock levels, sales performance, product trends, and inventory value.

## Features

### Report Includes:
- **Inventory Overview**
  - Total number of products
  - Low stock count
  - Out of stock count
  - Total inventory value

- **Sales Performance**
  - Number of orders for the week
  - Total revenue generated
  - Top 5 best-selling products with sales data

- **Stock Management**
  - Detailed low stock-product list with current quantities
  - Inventory breakdown by category
  - Product category statistics

- **Visual Dashboard**
  - Professional HTML email template
  - Color-coded metrics
  - Easy-to-read tables and statistics

## How It Works

### Automatic Scheduling (Recommended)

The system automatically generates and sends weekly reports every **Monday at 8:00 AM** using Laravel's task scheduler:

```bash
# Start the Laravel scheduler
php artisan schedule:work

# Or in production, add to your cron job:
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Manual Generation

You can also manually generate reports:

```bash
# Generate report only (without sending)
php artisan report:weekly

# Generate and send report immediately
php artisan report:weekly --send

# Generate report for a specific date
php artisan report:weekly --date=2026-02-23 --send
```

## Configuration

### Environment Variables

Ensure these are configured in your `.env` file:

```env
# Admin email recipients
ADMIN_EMAIL=admin@your-company.com
MAIL_FROM_ADDRESS=noreply@stockmaster.com
MAIL_FROM_NAME="Imperial Admin Account"

# Mail configuration (existing)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Customize Report Schedule

Edit [app/Console/Kernel.php](app/Console/Kernel.php) in the `schedule()` method:

```php
// Example: Send every Friday at 5:00 PM
$schedule->command('report:weekly --send')
    ->weeklyOn(5, '17:00') // Friday at 5:00 PM

// Example: Send daily at 6:00 AM
$schedule->command('report:weekly --send')
    ->dailyAt('06:00')

// Example: Send every other Monday
$schedule->command('report:weekly --send')
    ->weeklyOn(1, '08:00')
    ->when(function () {
        return now()->week % 2 == 0;
    })
```

## Services and Classes

### WeeklyReportService
Location: `app/Services/WeeklyReportService.php`

**Key Methods:**

| Method | Description |
|--------|-------------|
| `generateWeeklyReport($endDate = null)` | Generate report for a specific week |
| `sendReport(WeeklyReport $report)` | Send generated report via email |
| `generateAndSendWeeklyReport($endDate = null)` | Generate and send in one call |
| `getLowStockProducts()` | Get products currently below min stock |
| `getActiveNotifications()` | Get active low stock notifications |
| `getAllReports()` | Paginated list of all reports (10 per page) |
| `getLatestReport()` | Get the most recent report |
| `getReportForWeek(Carbon $date)` | Get report for specific week |

**Example Usage:**

```php
use App\Services\WeeklyReportService;

// In a controller or command
$reportService = app(WeeklyReportService::class);

// Generate and send
$success = $reportService->generateAndSendWeeklyReport();

// Get latest report
$latestReport = $reportService->getLatestReport();
echo "Last week's revenue: " . $latestReport->revenue;

// Query specific week
$date = Carbon\Carbon::parse('2026-02-20');
$report = $reportService->getReportForWeek($date);
```

### Updated EmailService
Location: `app/Services/EmailService.php`

**New Methods:**

- `sendWeeklyReport($report, array $adminEmails): bool` - Send formatted weekly report
- `getWeeklyReportEmailTemplate($report): string` - HTML email template

## Database Schema

### weekly_reports Table

```sql
CREATE TABLE weekly_reports (
    id BIGINT PRIMARY KEY,
    report_date DATE,              -- Date report was generated
    week_start DATE,               -- Start of reporting week
    week_end DATE,                 -- End of reporting week
    total_products INT,
    low_stock_count INT,
    out_of_stock_count INT,
    total_inventory_value DECIMAL(15, 2),
    orders_count INT,
    revenue DECIMAL(15, 2),
    top_products JSON,             -- JSON array of top 5 products
    low_stock_products JSON,       -- JSON array of low stock items
    report_data JSON,              -- Complete report data
    sent_to VARCHAR(255),          -- CSV of recipient emails
    sent_at TIMESTAMP,             -- When report was sent
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX (report_date),
    INDEX (week_start)
);
```

## Report Content Details

### 1. Key Metrics (Stats Grid)

Four main KPIs displayed:
- Total Products
- Total Inventory Value (in dollars)
- Orders This Week
- Revenue This Week (in dollars)

### 2. Stock Status Section

- Low stock items count with warning color
- Out of stock count with alert color

### 3. Top 5 Products Table

Shows best-selling products:
- Product name
- Quantity sold
- Revenue generated

### 4. Low Stock Products Table

Lists all products below minimum stock:
- Product name
- Current stock quantity
- Minimum required stock
- Color-coded warning

### 5. Inventory by Category

Category breakdown:
- Category name
- Number of products in category
- Total inventory value

## Usage Examples

### Example 1: Generate Weekly Report for Specific Date

```bash
php artisan report:weekly --date=2026-02-16 --send
```

### Example 2: View Report in Code

```php
use App\Models\WeeklyReport;

// Get latest report
$latest = WeeklyReport::latest()->first();

echo "Week: " . $latest->week_start . " to " . $latest->week_end;
echo "Revenue: $" . number_format($latest->revenue, 2);
echo "Low Stock Items: " . $latest->low_stock_count;

// Access top products
foreach ($latest->top_products as $product) {
    echo $product['name'] . " - " . $product['total_sold'] . " sold";
}
```

### Example 3: Query Reports by Date Range

```php
use App\Models\WeeklyReport;
use Carbon\Carbon;

$reports = WeeklyReport::whereBetween('week_start', [
    Carbon::now()->subMonths(1),
    Carbon::now()
])->get();

foreach ($reports as $report) {
    echo "Week of " . $report->week_start . ": $" . $report->revenue;
}
```

### Example 4: Monitor Report Generation

```php
use App\Services\WeeklyReportService;

$service = app(WeeklyReportService::class);

// Generate silently
$report = $service->generateWeeklyReport();

if ($report) {
    echo "Report generated for week " . $report->week_start;
    
    // Manually send later
    if ($service->sendReport($report)) {
        echo "Report sent successfully!";
    }
}
```

## Troubleshooting

### Report Not Sending

1. **Check mail configuration:**
   ```bash
   php artisan tinker
   echo env('ADMIN_EMAIL');
   echo env('MAIL_HOST');
   ```

2. **Test SMTP connection:**
   ```bash
   php artisan mail:send --test
   ```

3. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log | grep "Weekly report"
   ```

### Scheduler Not Running

1. **Verify schedule is configured:**
   ```bash
   php artisan schedule:list
   ```

2. **Test schedule manually:**
   ```bash
   php artisan schedule:run
   ```

3. **Start scheduler worker (development):**
   ```bash
   php artisan schedule:work
   ```

4. **Production setup:**
   Add to your crontab:
   ```bash
   * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
   ```

### Missing or Empty Data in Report

1. **Check if products exist:**
   ```php
   php artisan tinker
   App\Models\products::count()  // Should be > 0
   ```

2. **Verify orders for the week:**
   ```php
   App\Models\orders::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count()
   ```

3. **Check low stock configuration:**
   ```php
   App\Models\products::where('quantity', '<=', 5)->count()
   ```

## Email Template Features

The weekly report email includes:
- ✅ Professional gradient header with date range
- ✅ Embedded Imperial Admin Account logo
- ✅ Four key metric boxes with color coding
- ✅ Stock status indicators (warning/alert colors)
- ✅ Top 5 products table
- ✅ Low stock products table with red highlighting
- ✅ Category breakdown table
- ✅ Responsive design for mobile devices
- ✅ Action items and next steps

## Performance Considerations

### Large Datasets

For systems with thousands of products/orders:
- Reports are generated asynchronously
- Data is aggregated using optimized SQL queries
- JSON fields store pre-computed data to avoid recalculation

### Optimization Tips

1. **Use database indexes:**
   ```php
   // Already indexed in migration
   'index' => ['report_date', 'week_start']
   ```

2. **Archive old reports:**
   ```php
   // Keep only last 52 weeks
   WeeklyReport::where('created_at', '<', now()->subWeeks(52))->delete();
   ```

3. **Batch email sending:**
   Consider using Laravel Queues for large recipient lists

## Future Enhancements

Potential improvements:
- PDF export of weekly reports
- Customizable report sections
- YoY (Year-over-Year) comparisons
- Trending analysis and forecasting
- Multi-language support
- Slack/Teams integration
- Dashboard module to view all reports
- Custom report builder
- Report templates and customization
- Email scheduling by department

## Commands Reference

```bash
# Generate report for current week (no send)
php artisan report:weekly

# Generate and send report
php artisan report:weekly --send

# Generate for specific date
php artisan report:weekly --date=2026-02-20 --send

# View all commands
php artisan list
```

## Logs and Monitoring

All report activities are logged. View them:

```bash
# View all report-related logs
grep -i "weekly report\|report:" storage/logs/laravel.log

# Real-time monitoring
tail -f storage/logs/laravel.log | grep "Weekly"
```

## Support

For issues or questions:
1. Check `storage/logs/laravel.log` for errors
2. Verify mail configuration in `.env`
3. Test using `php artisan report:weekly` manually
4. Review source code comments in `WeeklyReportService.php`
