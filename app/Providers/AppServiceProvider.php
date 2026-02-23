<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EmailService;
use App\Services\LowStockNotificationService;
use App\Services\WeeklyReportService;
use App\Services\ProductService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register EmailService as singleton
        $this->app->singleton(EmailService::class, function ($app) {
            return new EmailService();
        });

        // Register LowStockNotificationService
        $this->app->singleton(LowStockNotificationService::class, function ($app) {
            return new LowStockNotificationService($app->make(EmailService::class));
        });

        // Register WeeklyReportService
        $this->app->singleton(WeeklyReportService::class, function ($app) {
            return new WeeklyReportService($app->make(EmailService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
