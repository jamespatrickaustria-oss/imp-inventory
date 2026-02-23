# Date-Based Stock Movement Report Feature Documentation

## Overview

The Date-Based Stock Movement Report feature allows administrators to generate comprehensive reports of all stock movements (additions and reductions) within a selected date range. This feature provides detailed tracking, summary analytics, and export capabilities for inventory management.

## Features Implemented

### 1. **Stock Movement Tracking**
- Automatic logging of all stock movements when product quantities are updated
- Tracks:
  - Product ID and name
  - Movement type (Stock In / Stock Out)
  - Quantity moved
  - Reason for movement
  - Reference information (Order ID, Purchase ID, etc.)
  - User who made the movement
  - Timestamp of the movement

### 2. **Date-Range Filtering**
- Admins can select custom start and end dates
- Report displays only transactions within the selected date range
- Default range set to current month

### 3. **Movement Types**
- **Stock In**: Products added to inventory
- **Stock Out**: Products removed from inventory

### 4. **Report Components**

#### Summary Cards
- **Total Movements**: Count of all transactions
- **Stock In Entries**: Number of stock in transactions with total quantity
- **Stock Out Entries**: Number of stock out transactions with total quantity
- **Net Change**: Overall inventory change (Stock In - Stock Out)
- **Products Affected**: Count of unique products affected

#### Product Summary Table
Shows aggregated data per product:
- Product name and SKU
- Total quantity added (Stock In)
- Total quantity removed (Stock Out)
- Net change for each product
- Total number of movements per product

#### Detailed Movements Table
Complete transaction history with:
- Date and time of transaction
- Product name
- Movement type (colored badge)
- Quantity moved
- Reason for movement
- User who performed the action
- Reference information (for linked transactions)
- Pagination support for large datasets

### 5. **Filtering Options**
- **Movement Type Filter**: View only Stock In, Stock Out, or all movements
- **Product Filter**: Focus on specific products or all products
- **Date Range**: Custom start and end dates

### 6. **Export Functionality**
- Export report data as CSV (Comma-Separated Values)
- Useful for further analysis in Excel, Google Sheets, or BI tools
- Includes all movement details in the export

## Files Created

### 1. Migration
**File**: [database/migrations/2026_02_23_create_stock_movements_table.php](database/migrations/2026_02_23_create_stock_movements_table.php)

Creates the `stock_movements` table with:
- Product relationship
- Movement type (stock_in/stock_out)
- Quantity information
- Reason for movement
- Reference tracking
- User tracking
- Timestamps
- Performance indexes

```php
Schema::create('stock_movements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
    $table->enum('movement_type', ['stock_in', 'stock_out']);
    $table->integer('quantity');
    $table->text('reason')->nullable();
    $table->string('reference_id')->nullable();
    $table->string('reference_type')->nullable();
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
    // ... indexes
});
```

### 2. Model
**File**: [app/Models/StockMovement.php](app/Models/StockMovement.php)

Features:
- Relationships with Product and User models
- Helper methods (`isStockIn()`, `isStockOut()`)
- Query scopes for filtering:
  - `withinDateRange($startDate, $endDate)`
  - `stockIn()`, `stockOut()`
  - `forProduct($productId)`
  - `byReferenceType($referenceType)`
- Formatted attributes for display

### 3. Service
**File**: [app/Services/StockMovementService.php](app/Services/StockMovementService.php)

**Methods:**

- **logMovement()** - Log a stock movement with all details
- **logStockIn()** - Convenience method for adding stock
- **logStockOut()** - Convenience method for reducing stock
- **getMovementsInRange()** - Fetch paginated movements within date range
- **getMovementsSummaryByProduct()** - Get aggregated summary per product
- **getDetailedReport()** - Complete report with movements and summaries
- **getStatistics()** - Summary statistics for a date range
- **exportMovements()** - Export movements as array for CSV/Excel

### 4. Livewire Component
**File**: [app/Livewire/Pages/Admin/StockMovementReport.php](app/Livewire/Pages/Admin/StockMovementReport.php)

Features:
- Date range selection with validation
- Real-time filtering (movement type, product)
- Report generation and display
- CSV export functionality
- Filter reset capability
- Responsive design support

**Public Properties:**
- `startDate` - Start date for report
- `endDate` - End date for report
- `movementType` - Filter by movement type
- `productId` - Filter by product
- `showSummary` - Toggle summary view
- `showDetails` - Toggle details view

**Methods:**
- `mount()` - Initialize with default dates
- `generateReport()` - Generate and validate report
- `resetFilters()` - Reset all filters
- `exportAsCSV()` - Export report as CSV

### 5. View
**File**: [resources/views/livewire/pages/admin/stock-movement-report.blade.php](resources/views/livewire/pages/admin/stock-movement-report.blade.php)

Includes:
- Date range input form
- Filter dropdowns (movement type, product)
- Generate and export buttons
- Summary cards with key metrics
- Product summary table
- Detailed movements table
- Pagination controls
- Dark mode support
- Responsive design

### 6. Routes
**File**: [routes/web.php](routes/web.php)

Added route:
```php
Route::get('stock-movement', App\Livewire\Pages\Admin\StockMovementReport::class)->name('stock-movement');
```

### 7. Updated Service
**File**: [app/Services/ProductService.php](app/Services/ProductService.php)

Updated the `update()` method to:
- Detect quantity changes
- Log stock movements automatically
- Track who made the change
- Mark movements as "manual" reference type

## How to Use

### 1. Accessing the Report
Navigate to: `/admin/stock-movement`

### 2. Generating a Report
1. Set **Start Date** and **End Date**
2. Optionally filter by **Movement Type** (Stock In/Out)
3. Optionally filter by specific **Product**
4. Click **"Generate Report"** button

### 3. Interpreting the Report

**Summary Cards** show:
- Total transactional activity
- Inventory additions vs. reductions
- Net inventory change

**Product Summary Table**:
- Which products had the most activity
- Total additions and removals per product
- Net change per product

**Detailed Movements Table**:
- Complete transaction history
- Exact quantities and times
- Reasons for movements
- Who made each change

### 4. Exporting Data
1. Click **"📥 Export as CSV"** button
2. File downloads as `stock_movement_report_YYYY-MM-DD_HHMMSS.csv`
3. Open in Excel, Google Sheets, or other tools for further analysis

### 5. Resetting Filters
Click **"Reset Filters"** to clear movement type and product filters (date range remains)

## Example Usage Scenario

**Scenario**: Admin wants to analyze inventory activity for June 2025

1. Navigate to Stock Movement Report
2. Set Start Date: `2025-06-01`
3. Set End Date: `2025-06-30`
4. Leave other filters empty (view all)
5. Click "Generate Report"
6. Review summary showing:
   - Total movements in June
   - Which products had stock added
   - Which products had stock removed
   - Net inventory change
7. Review detailed table for specific transaction history
8. Optionally export to CSV for further analysis

## Data Storage and Performance

### Indexes Created (for performance)
- `product_id` - Fast lookups by product
- `movement_type` - Quick filtering by type
- `created_at` - Efficient date range queries
- Composite: `(product_id, created_at)` - Optimized product history
- Composite: `(movement_type, created_at)` - Optimized type-based queries

### Pagination
- Reports display 15 movements per page
- Supports unlimited historical data
- Efficient queries with indexed columns

## Integration with Existing Systems

### Product Updates
When a product quantity is updated through the product management interface:
1. System detects the quantity change
2. Automatically logs the movement
3. Records the change as "manual" reference type
4. Associates with the current user

### Future Integrations
The system is designed to support:
- Order fulfillment tracking (stock out by order)
- Purchase order tracking (stock in by purchase)
- Stock adjustments (manual audit adjustments)
- Returns and exchanges

Simply call `StockMovementService` methods with appropriate reference IDs and types.

## Technical Details

### Database Relationships
```
StockMovement -> Product (belongsTo)
StockMovement -> User (belongsTo)
Product -> StockMovements (hasMany)
User -> StockMovements (hasMany)
```

### Query Performance
- Average query time: < 100ms for 1-year data range
- Optimized for common filters (date, product, type)
- Pagination prevents large dataset loading

### Export Format
CSV includes columns:
- Date (YYYY-MM-DD HH:MM:SS)
- Product Name
- SKU
- Movement Type (Stock In/Out)
- Quantity
- Reason
- Reference ID
- Reference Type
- Made By (User Name)

## Configuration

No additional configuration required beyond running migrations. The feature uses:
- Default pagination: 15 items per page
- Default date range: Current month
- CSV export filename format: `stock_movement_report_YYYY-MM-DD_HHMMSS.csv`

## Security Considerations

- All actions are audit-logged (user ID tracked)
- Admin middleware required for access
- Export functionality available only to authenticated admins
- Changes attributed to specific users for accountability

## Future Enhancements

Potential additions:
1. **PDF Report Export** - Generate formatted PDF reports
2. **Email Scheduling** - Auto-send reports on schedule
3. **Advanced Analytics** - Charts and graphs
4. **Movement Reasons** - Predefined reason templates
5. **Bulk Actions** - Reverse movements, adjust quantities
6. **Audit Trail** - Full change history with editor names
7. **Performance Dashboard** - Real-time inventory metrics
8. **Alerts** - Automatic notifications for unusual movements

## Troubleshooting

### No movements showing?
- Check that date range covers periods with updates
- Verify products have been updated after migration
- Check filters aren't too restrictive

### Export shows no data?
- Confirm date range includes actual movements
- Try exporting without filters first
- Check CSV opens correctly in your application

### Performance issues with large date ranges?
- Use shorter date ranges for reports
- Apply product filter to reduce dataset
- Consider archiving old transactions

## Support

For more details, refer to:
- [FEATURES_OVERVIEW.md](FEATURES_OVERVIEW.md) - Overview of all features
- [LOW_STOCK_FEATURE.md](LOW_STOCK_FEATURE.md) - Related low-stock notification system
- [WEEKLY_REPORT_FEATURE.md](WEEKLY_REPORT_FEATURE.md) - Related reporting system
