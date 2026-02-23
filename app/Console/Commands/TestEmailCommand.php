<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailService;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : The email address to send test OTP to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test OTP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Testing email configuration...');
        $this->info("Sending test OTP to: $email");
        
        try {
            $emailService = app(EmailService::class);
            $testOtp = '123456';
            
            $result = $emailService->sendOTP($email, $testOtp, 'register');
            
            if ($result) {
                $this->info('✓ Email sent successfully!');
                $this->info("Test OTP: $testOtp");
                $this->info('Check your inbox (and spam folder).');
                return Command::SUCCESS;
            } else {
                $this->error('✗ Failed to send email.');
                $this->error('Check your .env configuration and logs in storage/logs/laravel.log');
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error('✗ Error: ' . $e->getMessage());
            $this->error('Check your .env configuration and logs in storage/logs/laravel.log');
            return Command::FAILURE;
        }
    }
}

