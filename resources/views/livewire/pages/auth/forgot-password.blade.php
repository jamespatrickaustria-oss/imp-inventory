<?php

use App\Services\OtpService;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send OTP for password reset.
     */
    public function sendPasswordResetOtp(OtpService $otpService): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Check if user exists
        $user = User::where('email', $this->email)->first();
        
        if (!$user) {
            $this->addError('email', 'We could not find a user with that email address.');
            return;
        }

        // Store email in session
        session(['reset_email' => $this->email]);

        // Generate and send OTP
        if (!$otpService->generateAndSend($this->email, 'reset_password')) {
            $this->addError('email', '❌ Failed to send verification code. Please try again.');
            session()->flash('error', 'Failed to send verification code. Please check your email and try again.');
            return;
        }

        // Set success message for next page
        session()->flash('status', '✓ Verification code sent! Please check your email.');

        // Redirect to OTP verification page
        $this->redirect(route('verify-otp-reset'), navigate: true);
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
    <!-- Error Message -->
    @if (session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium text-sm text-red-800 dark:text-red-300">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetOtp">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send Verification Code') }}
            </x-primary-button>
        </div>
    </form>
</div>
