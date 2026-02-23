# Low Stock Notification Feature Documentation

## Overview

The Low Stock Notification feature automatically monitors product inventory levels and sends email alerts to administrators when stock quantities reach or fall below the configured minimum threshold.

## How It Works

### 1. **Stock Level Monitoring**
- Every time a product is created or updated, the system checks if the quantity is at or below the `min_stock` value
- Products have a default minimum stock level of 5 items, but this can be customized per product

### 2. **Notification Logic**
- When stock falls to the threshold level, an email notification is triggered
- A record is created in the `low_stock_notifications` table to track the notification event
- **Important**: The notification only sends ONCE per low-stock event
- Once stock is replenished above the minimum level, the notification is marked as inactive
- If stock drops to the minimum level again, a new notification is sent

### 3. **Email Notification**
The system sends a professionally formatted HTML email containing:
- **Product Information**:
  - Product name
  - SKU (stock keeping unit)
  - Product category
  - Current stock quantity
  - Minimum stock level
  - Unit price

- **Visual Alerts**:
  - Orange warning header
  - Highlighted low stock quantity in red
  - Warning message emphasized with icon
  - Embedded Imperial Admin Account logo

- **Attachments**:
  - `imp.png` is attached to each email for company branding

### 4. **Email Recipients**
Notifications are sent to admin email addresses configured in your `.env` file:
- Primary: `ADMIN_EMAIL`
- Fallback: `MAIL_FROM_ADDRESS`

## Configuration

### Environment Variables

Add the following to your `.env` file:

```env
# Mail Configuration (existing)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@stockmaster.com
MAIL_FROM_NAME="Imperial Admin Account"

# Admin Email for Low Stock Notifications (NEW)
ADMIN_EMAIL=admin@your-company.com
```

**Note**: If `ADMIN_EMAIL` is not set, the system will use `MAIL_FROM_ADDRESS` as fallback.

### Database Schema

The feature uses the `low_stock_notifications` table:

```sql
CREATE TABLE low_stock_notifications (
    id BIGINT PRIMARY KEY,
    product_id BIGINT NOT NULL (foreign key to products),
    quantity_when_notified INT,
    notified_at TIMESTAMP,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY (product_id, is_active)
);
```

The `is_active` flag prevents duplicate notifications for the same product when stock is already low.

## Product Configuration

### Setting Minimum Stock Level

When creating or editing a product, set the `min_stock` field (default: 5):

```php
// Create product with custom min_stock
$product = Product::create([
    'name' => 'Laptop',
    'sku' => 'LAPTOP-001',
    'quantity' => 3,  // Below threshold, triggers notification
    'min_stock' => 5,
    // ... other fields
]);
```

### Automatic Notification

The notification is automatically triggered when:
1. Product quantity is updated to ≤ min_stock level
2. New product is created with quantity ≤ min_stock level

## Services and Classes

### 1. **LowStockNotificationService**
Location: `app/Services/LowStockNotificationService.php`

**Methods**:
- `checkAndNotify(products $product): bool` - Main method to check stock and trigger notification
- `getLowStockProducts()` - Get all currently low-stock products
- `getActiveNotifications()` - Get all active low-stock notifications

**Example Usage**:
```php
$notificationService = app(LowStockNotificationService::class);
$notificationService->checkAndNotify($product);
```

### 2. **EmailService**
Location: `app/Services/EmailService.php`

**New Methods**:
- `sendLowStockNotification($product): bool` - Sends formatted email notification
- `getAdminEmails(): array` - Retrieves admin email addresses
- `getLowStockEmailTemplate($product): string` - Gets HTML email template

### 3. **ProductService**
Location: `app/Services/ProductService.php`

**Updated Methods**:
- `store(array $data)` - Creates product and checks for low stock
- `update($id, array $data)` - Updates product and checks for low stock

### 4. **LowStockNotification Model**
Location: `app/Models/LowStockNotification.php`

Tracks which products have been notified about low stock status.

## Testing the Feature

### Test Scenario 1: Creating a Low-Stock Product

```bash
# Using Tinker (Laravel interactive shell)
php artisan tinker

# Create a product with low stock
$product = App\Models\products::create([
    'name' => 'Test Product',
    'sku' => 'TEST-001',
    'category_id' => 1,
    'price' => 99.99,
    'quantity' => 3,      // Below min_stock (5)
    'min_stock' => 5
]);

# Notification should be sent automatically and logged
```

### Test Scenario 2: Updating Stock to Low Level

```bash
php artisan tinker

# Find a product with sufficient stock
$product = App\Models\products::find(1);

# Update quantity to trigger notification
$product->update(['quantity' => 2]);  # Triggers notification

# Check that notification was recorded
$notification = App\Models\LowStockNotification::where('product_id', 1)
    ->where('is_active', true)
    ->first();

# $notification should exist
```

### Test Scenario 3: Preventing Duplicate Notifications

```bash
php artisan tinker

# Product already has a low-stock notification
$product = App\Models\products::find(1);

# Try updating again (should NOT send another email)
$product->update(['quantity' => 1]);

# Only ONE active notification should exist
$activeNotifications = App\Models\LowStockNotification::where('product_id', 1)
    ->where('is_active', true)
    ->count();

# Result: 1 (no duplicate)
```

### Test Scenario 4: Restocking Clears Notification

```bash
php artisan tinker

$product = App\Models\products::find(1);

# Restock above minimum
$product->update(['quantity' => 10]);  # Above min_stock (5)

# Previous notification should now be inactive
$activeNotification = App\Models\LowStockNotification::where('product_id', 1)
    ->where('is_active', true)
    ->first();

# Result: null (notification is inactive)

# Stock falls again, new notification is sent
$product->update(['quantity' => 2]);

# New notification should be created
$newNotification = App\Models\LowStockNotification::where('product_id', 1)
    ->where('is_active', true)
    ->first();

# Result: new notification exists
```

## Viewing Logs

All notification attempts are logged. View them with:

```bash
# Check the log file
tail -f storage/logs/laravel.log

# Or filter for low stock related entries
grep -i "low stock" storage/logs/laravel.log
```

## Email Template Features

The email template includes:
- ✅ Embedded Imperial Admin Account logo
- ✅ Color-coded warning indicators (orange/red)
- ✅ Product details in organized table format
- ✅ Action-required message
- ✅ Attached imp.png file
- ✅ Professional HTML formatting
- ✅ Mobile-responsive design

## Troubleshooting

### Email Not Sending

1. **Check environment variables**:
   ```bash
   php artisan tinker
   echo env('ADMIN_EMAIL');
   echo env('MAIL_FROM_ADDRESS');
   ```

2. **Verify SMTP configuration**:
   - Check `.env` file for correct MAIL_* settings
   - Test with a simple OTP email first

3. **Check logs**:
   ```bash
   tail -f storage/logs/laravel.log | grep "Low stock"
   ```

### Duplicate Notifications Still Occurring

1. Clear any stale active notifications:
   ```php
   // In Tinker
   $product = Product::find(1);
   LowStockNotification::where('product_id', 1)
       ->where('is_active', true)
       ->update(['is_active' => false]);
   ```

### Notification Not Triggering

1. Verify product min_stock is configured
2. Check that quantity is actually ≤ min_stock
3. View database records:
   ```bash
   php artisan tinker
   App\Models\products::find(1)->toArray();  # Check quantity and min_stock
   ```

## Performance Considerations

- Notifications are sent synchronously with product updates
- For high-volume operations, consider using Laravel Queues:
  ```php
  // In LowStockNotificationService::checkAndNotify()
  SendLowStockEmail::dispatch($product)->onQueue('emails');
  ```

- The `unique(['product_id', 'is_active'])` constraint prevents database bloat

## Future Enhancements

Potential improvements:
- SMS notifications for urgent low-stock alerts
- Scheduled daily/weekly digest emails
- Configurable notification frequency
- Multiple admin email recipients with role-based filtering
- Auto-reorder integration
- Stock threshold percentage-based alerts
- Slack/Teams integration

## Support

For issues or questions about this feature:
1. Check the logs in `storage/logs/laravel.log`
2. Review the source code comments
3. Verify `.env` configuration
4. Test using Tinker as shown in testing scenarios
