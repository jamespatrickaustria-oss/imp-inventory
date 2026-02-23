<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class EmailService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    /**
     * Configure PHPMailer settings
     */
    protected function configure(): void
    {
        try {
            // SMTP Configuration
            $this->mailer->isSMTP();
            $this->mailer->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = env('MAIL_USERNAME');
            $this->mailer->Password = env('MAIL_PASSWORD');
            $this->mailer->SMTPSecure = env('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
            $this->mailer->Port = env('MAIL_PORT', 587);
            
            // From Address
            $this->mailer->setFrom(
                env('MAIL_FROM_ADDRESS', 'noreply@stockmaster.com'),
                env('MAIL_FROM_NAME', 'Imperial Admin Account')
            );
            
            // Encoding
            $this->mailer->CharSet = 'UTF-8';
            $this->mailer->isHTML(true);
            
        } catch (Exception $e) {
            Log::error('PHPMailer configuration error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send OTP email
     */
    public function sendOTP(string $email, string $otp, string $type = 'register'): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);

            // Embed logo image
            $logoPath = public_path('images/imp.png');
            if (file_exists($logoPath)) {
                $this->mailer->addEmbeddedImage($logoPath, 'logo', 'imp.png', 'base64', 'image/png');
            }

            if ($type === 'register') {
                $this->mailer->Subject = 'Registration OTP - Imperial Admin Account';
                $this->mailer->Body = $this->getRegistrationEmailTemplate($otp);
            } else {
                $this->mailer->Subject = 'Password Reset OTP - Imperial Admin Account';
                $this->mailer->Body = $this->getPasswordResetEmailTemplate($otp);
            }

            $this->mailer->AltBody = "Your OTP is: $otp. This code will expire in 10 minutes.";

            $result = $this->mailer->send();
            
            if ($result) {
                Log::info("OTP email sent successfully to: $email");
            }
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get registration email template
     */
    protected function getRegistrationEmailTemplate(string $otp): string
    {
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .logo { text-align: center; margin-bottom: 20px; }
                    .logo img { max-width: 150px; height: auto; }
                    .header { background-color: #4F46E5; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background-color: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                    .otp-box { background-color: white; border: 2px dashed #4F46E5; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px; }
                    .otp-code { font-size: 32px; font-weight: bold; color: #4F46E5; letter-spacing: 5px; }
                    .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px; }
                    .warning { color: #dc2626; margin-top: 15px; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='logo'>
                        <img src='cid:logo' alt='Imperial Admin Account' />
                    </div>
                    <div class='header'>
                        <h1>Welcome to Imperial Admin Account!</h1>
                    </div>
                    <div class='content'>
                        <p>Thank you for registering with Imperial Admin Account. To complete your registration, please use the following One-Time Password (OTP):</p>
                        
                        <div class='otp-box'>
                            <p style='margin: 0; font-size: 14px; color: #6b7280;'>Your OTP Code</p>
                            <div class='otp-code'>$otp</div>
                        </div>
                        
                        <p>This code will expire in <strong>10 minutes</strong>.</p>
                        
                        <p class='warning'>⚠️ Do not share this code with anyone. Our team will never ask for your OTP.</p>
                        
                        <p>If you didn't request this registration, please ignore this email.</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 Imperial Admin Account. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }

    /**
     * Get password reset email template
     */
    protected function getPasswordResetEmailTemplate(string $otp): string
    {
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .logo { text-align: center; margin-bottom: 20px; }
                    .logo img { max-width: 150px; height: auto; }
                    .header { background-color: #dc2626; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background-color: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                    .otp-box { background-color: white; border: 2px dashed #dc2626; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px; }
                    .otp-code { font-size: 32px; font-weight: bold; color: #dc2626; letter-spacing: 5px; }
                    .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px; }
                    .warning { color: #dc2626; margin-top: 15px; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='logo'>
                        <img src='cid:logo' alt='Imperial Admin Account' />
                    </div>
                    <div class='header'>
                        <h1>Password Reset Request</h1>
                    </div>
                    <div class='content'>
                        <p>We received a request to reset your password for your Imperial Admin Account. Use the following One-Time Password (OTP) to proceed:</p>
                        
                        <div class='otp-box'>
                            <p style='margin: 0; font-size: 14px; color: #6b7280;'>Your OTP Code</p>
                            <div class='otp-code'>$otp</div>
                        </div>
                        
                        <p>This code will expire in <strong>10 minutes</strong>.</p>
                        
                        <p class='warning'>⚠️ Do not share this code with anyone. If you didn't request a password reset, please ignore this email and ensure your account is secure.</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 Imperial Admin Account. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }

    /**
     * Send low stock notification email
     */
    public function sendLowStockNotification($product): bool
    {
        try {
            // Get admin email(s)
            $adminEmails = $this->getAdminEmails();
            
            if (empty($adminEmails)) {
                Log::warning('No admin email addresses configured for low stock notifications');
                return false;
            }

            $this->mailer->clearAddresses();
            
            // Add all admin recipients
            foreach ($adminEmails as $email) {
                $this->mailer->addAddress($email);
            }

            // Embed logo image
            $logoPath = public_path('images/imp.png');
            if (file_exists($logoPath)) {
                $this->mailer->addEmbeddedImage($logoPath, 'logo', 'imp.png', 'base64', 'image/png');
            }

            // Attach imp.png if it exists
            if (file_exists($logoPath)) {
                $this->mailer->addAttachment($logoPath, 'imp.png');
            }

            $this->mailer->Subject = "⚠️ Low Stock Alert: {$product->name}";
            $this->mailer->Body = $this->getLowStockEmailTemplate($product);
            $this->mailer->AltBody = "Low stock alert for product: {$product->name}. Current quantity: {$product->quantity}. Please restock this item.";

            $result = $this->mailer->send();
            
            if ($result) {
                Log::info("Low stock notification email sent for product: {$product->name}");
            }
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('Failed to send low stock notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get admin email addresses from environment or database
     */
    protected function getAdminEmails(): array
    {
        $emails = [];
        
        // First try to get from environment variable
        $adminEmail = env('ADMIN_EMAIL');
        if ($adminEmail) {
            $emails[] = $adminEmail;
        }
        
        // Also get from MAIL_FROM_ADDRESS if set
        $fromEmail = env('MAIL_FROM_ADDRESS');
        if ($fromEmail && !in_array($fromEmail, $emails)) {
            $emails[] = $fromEmail;
        }

        return $emails;
    }

    /**
     * Get low stock email template
     */
    protected function getLowStockEmailTemplate($product): string
    {
        $categoryName = $product->category?->name ?? 'N/A';
        $stockStatus = $product->quantity == 0 ? '❌ OUT OF STOCK' : "⚠️ LOW STOCK ({$product->quantity} items)";
        
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .logo { text-align: center; margin-bottom: 20px; }
                    .logo img { max-width: 150px; height: auto; }
                    .header { background-color: #ea580c; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background-color: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                    .alert-box { background-color: #fee2e2; border-left: 4px solid #dc2626; padding: 15px; margin: 20px 0; border-radius: 4px; }
                    .alert-box h2 { color: #dc2626; margin: 0 0 10px 0; font-size: 18px; }
                    .product-details { background-color: white; border: 1px solid #e5e7eb; padding: 20px; margin: 20px 0; border-radius: 8px; }
                    .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
                    .detail-row:last-child { border-bottom: none; }
                    .detail-label { font-weight: bold; color: #374151; }
                    .detail-value { color: #6b7280; }
                    .warning-message { color: #dc2626; font-size: 16px; margin: 20px 0; padding: 15px; background-color: #fef2f2; border-radius: 4px; }
                    .action-button { display: inline-block; background-color: #ea580c; color: white; padding: 12px 20px; text-decoration: none; border-radius: 4px; margin-top: 20px; }
                    .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='logo'>
                        <img src='cid:logo' alt='Imperial Admin Account' />
                    </div>
                    <div class='header'>
                        <h1>Stock Alert Notification</h1>
                    </div>
                    <div class='content'>
                        <div class='alert-box'>
                            <h2>$stockStatus</h2>
                            <p>The following product requires immediate attention:</p>
                        </div>
                        
                        <div class='product-details'>
                            <div class='detail-row'>
                                <span class='detail-label'>Product Name:</span>
                                <span class='detail-value'>{$product->name}</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>SKU:</span>
                                <span class='detail-value'>{$product->sku}</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Category:</span>
                                <span class='detail-value'>$categoryName</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Current Stock:</span>
                                <span class='detail-value' style='color: #dc2626; font-weight: bold;'>{$product->quantity} items</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Minimum Stock Level:</span>
                                <span class='detail-value'>{$product->min_stock} items</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Unit Price:</span>
                                <span class='detail-value'>\${$product->price}</span>
                            </div>
                        </div>
                        
                        <div class='warning-message'>
                            <strong>⚠️ Action Required:</strong> Please review and restock this item as soon as possible to avoid sales disruption.
                        </div>
                        
                        <p>This is an automated alert from StockMaster Pro. Please log in to your admin dashboard to take action.</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 Imperial Admin Account. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }

    /**
     * Send weekly report email
     */
    public function sendWeeklyReport($report, array $adminEmails): bool
    {
        try {
            $this->mailer->clearAddresses();
            
            // Add all admin recipients
            foreach ($adminEmails as $email) {
                $this->mailer->addAddress($email);
            }

            // Embed logo image
            $logoPath = public_path('images/imp.png');
            if (file_exists($logoPath)) {
                $this->mailer->addEmbeddedImage($logoPath, 'logo', 'imp.png', 'base64', 'image/png');
            }

            $this->mailer->Subject = "📊 Weekly Inventory & Sales Report - {$report->week_start->format('M d')} to {$report->week_end->format('M d, Y')}";
            $this->mailer->Body = $this->getWeeklyReportEmailTemplate($report);
            $this->mailer->AltBody = "Weekly Report: {$report->orders_count} orders, \${$report->revenue} revenue, {$report->low_stock_count} low stock items.";

            $result = $this->mailer->send();
            
            if ($result) {
                Log::info("Weekly report email sent to: " . implode(', ', $adminEmails));
            }
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('Failed to send weekly report: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get weekly report email template
     */
    protected function getWeeklyReportEmailTemplate($report): string
    {
        $weekRange = $report->week_start->format('M d') . ' - ' . $report->week_end->format('M d, Y');
        
        // Format top products
        $topProductsHtml = '';
        if (!empty($report->top_products)) {
            $topProductsHtml = '<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">';
            $topProductsHtml .= '<tr style="background-color: #f3f4f6; border-bottom: 2px solid #e5e7eb;"><th style="padding: 10px; text-align: left;">Product</th><th style="padding: 10px; text-align: center;">Sold</th><th style="padding: 10px; text-align: right;">Revenue</th></tr>';
            
            foreach ($report->top_products as $index => $product) {
                $bgColor = $index % 2 == 0 ? '#ffffff' : '#f9fafb';
                $topProductsHtml .= '<tr style="background-color: ' . $bgColor . '; border-bottom: 1px solid #e5e7eb;">';
                $topProductsHtml .= '<td style="padding: 10px;">' . htmlspecialchars($product['name']) . '</td>';
                $topProductsHtml .= '<td style="padding: 10px; text-align: center;">' . $product['total_sold'] . '</td>';
                $topProductsHtml .= '<td style="padding: 10px; text-align: right;">\$' . number_format($product['revenue'], 2) . '</td>';
                $topProductsHtml .= '</tr>';
            }
            
            $topProductsHtml .= '</table>';
        }

        // Format low stock products
        $lowStockHtml = '';
        if (!empty($report->low_stock_products)) {
            $lowStockHtml = '<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">';
            $lowStockHtml .= '<tr style="background-color: #fee2e2; border-bottom: 2px solid #dc2626;"><th style="padding: 10px; text-align: left;">Product</th><th style="padding: 10px; text-align: center;">Stock</th><th style="padding: 10px; text-align: center;">Min</th></tr>';
            
            foreach ($report->low_stock_products as $product) {
                $lowStockHtml .= '<tr style="background-color: #fef2f2; border-bottom: 1px solid #fecaca;">';
                $lowStockHtml .= '<td style="padding: 10px;">' . htmlspecialchars($product['name']) . '</td>';
                $lowStockHtml .= '<td style="padding: 10px; text-align: center; color: #dc2626; font-weight: bold;">' . $product['quantity'] . '</td>';
                $lowStockHtml .= '<td style="padding: 10px; text-align: center;">' . $product['min_stock'] . '</td>';
                $lowStockHtml .= '</tr>';
            }
            
            $lowStockHtml .= '</table>';
        }

        // Format categories
        $categoriesHtml = '';
        if (!empty($report->report_data['product_categories'])) {
            $categoriesHtml = '<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">';
            $categoriesHtml .= '<tr style="background-color: #f3f4f6; border-bottom: 2px solid #e5e7eb;"><th style="padding: 10px; text-align: left;">Category</th><th style="padding: 10px; text-align: center;">Products</th><th style="padding: 10px; text-align: right;">Inventory Value</th></tr>';
            
            foreach ($report->report_data['product_categories'] as $category) {
                $categoriesHtml .= '<tr style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">';
                $categoriesHtml .= '<td style="padding: 10px;">' . htmlspecialchars($category['category']) . '</td>';
                $categoriesHtml .= '<td style="padding: 10px; text-align: center;">' . $category['product_count'] . '</td>';
                $categoriesHtml .= '<td style="padding: 10px; text-align: right;">\$' . number_format($category['inventory_value'], 2) . '</td>';
                $categoriesHtml .= '</tr>';
            }
            
            $categoriesHtml .= '</table>';
        }

        return "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 800px; margin: 0 auto; padding: 20px; }
                    .logo { text-align: center; margin-bottom: 20px; }
                    .logo img { max-width: 150px; height: auto; }
                    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                    .header h1 { margin: 0; font-size: 28px; }
                    .subheader { font-size: 14px; margin-top: 5px; opacity: 0.9; }
                    .content { background-color: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                    .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
                    .stat-box { background-color: white; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; }
                    .stat-label { font-size: 12px; color: #6b7280; text-transform: uppercase; }
                    .stat-value { font-size: 28px; font-weight: bold; color: #1f2937; margin-top: 5px; }
                    .section { margin: 30px 0; }
                    .section h2 { color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 15px; font-size: 18px; }
                    .highlight { background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 15px; border-radius: 4px; margin: 15px 0; }
                    .alert { background-color: #fee2e2; border-left: 4px solid #dc2626; padding: 15px; border-radius: 4px; margin: 15px 0; }
                    .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 12px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='logo'>
                        <img src='cid:logo' alt='Imperial Admin Account' />
                    </div>
                    <div class='header'>
                        <h1>📊 Weekly Report</h1>
                        <div class='subheader'>$weekRange</div>
                    </div>
                    <div class='content'>
                        
                        <!-- Key Metrics -->
                        <div class='stats-grid'>
                            <div class='stat-box'>
                                <div class='stat-label'>Total Products</div>
                                <div class='stat-value'>{$report->total_products}</div>
                            </div>
                            <div class='stat-box'>
                                <div class='stat-label'>Total Inventory Value</div>
                                <div class='stat-value'>\$" . number_format($report->total_inventory_value, 2) . "</div>
                            </div>
                            <div class='stat-box'>
                                <div class='stat-label'>Orders This Week</div>
                                <div class='stat-value'>{$report->orders_count}</div>
                            </div>
                            <div class='stat-box'>
                                <div class='stat-label'>Revenue</div>
                                <div class='stat-value'>\$" . number_format($report->revenue, 2) . "</div>
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class='section'>
                            <h2>📦 Stock Status</h2>
                            <div class='stat-box' style='border-left-color: #f59e0b;'>
                                <div class='stat-label'>Low Stock Items</div>
                                <div class='stat-value' style='color: #f59e0b;'>{$report->low_stock_count}</div>
                            </div>
                            <div class='stat-box' style='border-left-color: #dc2626; margin-top: 10px;'>
                                <div class='stat-label'>Out of Stock</div>
                                <div class='stat-value' style='color: #dc2626;'>{$report->out_of_stock_count}</div>
                            </div>
                        </div>

                        " . ($report->low_stock_count > 0 ? "
                        <div class='alert'>
                            <strong>⚠️ Action Required:</strong> {$report->low_stock_count} product(s) need restocking. See details below.
                        </div>
                        " : "
                        <div class='highlight'>
                            <strong>✅ Good News:</strong> All products are adequately stocked!
                        </div>
                        ") . "

                        <!-- Top Products -->
                        " . (!empty($report->top_products) ? "
                        <div class='section'>
                            <h2>🏆 Top 5 Products</h2>
                            $topProductsHtml
                        </div>
                        " : "") . "

                        <!-- Low Stock Products -->
                        " . (!empty($report->low_stock_products) ? "
                        <div class='section'>
                            <h2>⚠️ Low Stock Products</h2>
                            $lowStockHtml
                        </div>
                        " : "") . "

                        <!-- Category Breakdown -->
                        " . (!empty($report->report_data['product_categories']) ? "
                        <div class='section'>
                            <h2>📂 Inventory by Category</h2>
                            $categoriesHtml
                        </div>
                        " : "") . "

                        <div class='highlight'>
                            <p><strong>📈 Report Generated:</strong> " . now()->format('F d, Y \a\t H:i A') . "</p>
                            <p>This is an automated weekly report from StockMaster Pro. Log in to your admin dashboard for more details.</p>
                        </div>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 Imperial Admin Account. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }
}
