<?php

namespace App\Services;

use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Generate and send OTP
     */
    public function generateAndSend(string $email, string $type = 'register'): bool
    {
        try {
            // Delete old OTPs for this email and type
            Otp::where('email', $email)
                ->where('type', $type)
                ->where('is_verified', false)
                ->delete();

            // Generate 6-digit OTP
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store OTP in database
            Otp::create([
                'email' => $email,
                'otp' => $otpCode,
                'type' => $type,
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_verified' => false,
            ]);

            // Send OTP via email
            $sent = $this->emailService->sendOTP($email, $otpCode, $type);

            if (!$sent) {
                Log::error("Failed to send OTP to email: $email");
                return false;
            }

            Log::info("OTP generated and sent successfully to: $email");
            return true;

        } catch (\Exception $e) {
            Log::error('OTP generation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify OTP
     */
    public function verify(string $email, string $otpCode, string $type = 'register'): bool
    {
        try {
            $otp = Otp::where('email', $email)
                ->where('type', $type)
                ->where('is_verified', false)
                ->latest()
                ->first();

            if (!$otp) {
                Log::warning("No OTP found for email: $email");
                return false;
            }

            if ($otp->isExpired()) {
                Log::warning("OTP expired for email: $email");
                return false;
            }

            if ($otp->otp !== $otpCode) {
                Log::warning("Invalid OTP attempt for email: $email");
                return false;
            }

            // Mark as verified
            $otp->markAsVerified();
            
            Log::info("OTP verified successfully for: $email");
            return true;

        } catch (\Exception $e) {
            Log::error('OTP verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if email has verified OTP
     */
    public function hasVerifiedOtp(string $email, string $type = 'register'): bool
    {
        return Otp::where('email', $email)
            ->where('type', $type)
            ->where('is_verified', true)
            ->where('created_at', '>=', Carbon::now()->subMinutes(30))
            ->exists();
    }

    /**
     * Clean up old OTPs
     */
    public function cleanup(): void
    {
        Otp::where('expires_at', '<', Carbon::now()->subHours(24))
            ->orWhere('created_at', '<', Carbon::now()->subDays(7))
            ->delete();
    }
}
