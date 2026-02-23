<?php

use App\Services\OtpService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $otp = '';
    public string $name = '';
    public string $password = '';

    public function mount()
    {
        // Get data from session (passed from register page)
        $this->email = session('registration_email', '');
        $this->name = session('registration_name', '');
        $this->password = session('registration_password', '');

        // Redirect if no registration session
        if (!$this->email) {
            $this->redirect(route('register'), navigate: true);
        }
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyOtp(OtpService $otpService): void
    {
        $this->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        // Verify OTP
        if (!$otpService->verify($this->email, $this->otp, 'register')) {
            $this->addError('otp', '❌ Invalid or expired OTP. Please check your code and try again.');
            session()->flash('error', 'The OTP you entered is incorrect or has expired. Please try again or request a new code.');
            $this->otp = ''; // Clear the OTP input
            return;
        }

        // OTP is correct - show success message
        session()->flash('success', '✓ OTP verified successfully! Creating your account...');

        // Create user
        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => \Illuminate\Support\Facades\Hash::make($this->password),
        ]);

        // Fire registered event
        event(new \Illuminate\Auth\Events\Registered($user));

        // Login user
        \Illuminate\Support\Facades\Auth::login($user);

        // Clear session data
        session()->forget(['registration_email', 'registration_name', 'registration_password']);

        // Redirect to dashboard with success message
        session()->flash('status', 'Registration completed successfully! Welcome to Imperial Admin Account.');
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(OtpService $otpService): void
    {
        if (!$this->email) {
            $this->addError('otp', 'Session expired. Please start registration again.');
            session()->flash('error', 'Session expired. Please start registration again.');
            return;
        }

        if ($otpService->generateAndSend($this->email, 'register')) {
            session()->flash('status', '✓ A new OTP has been sent to your email. Please check your inbox.');
        } else {
            $this->addError('otp', 'Failed to send OTP. Please try again.');
            session()->flash('error', '❌ Failed to send OTP. Please try again later.');
        }
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        {{ __('We have sent a 6-digit verification code to') }} <strong>{{ $email }}</strong>. 
        {{ __('Please enter the code below to complete your registration.') }}
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

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

    <!-- Status Message -->
    @if (session('status'))
        <div class="mb-4 p-4 rounded-lg bg-blue-50 border border-blue-200 dark:bg-blue-900/20 dark:border-blue-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium text-sm text-blue-800 dark:text-blue-300">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit="verifyOtp">
        <!-- OTP Input -->
        <div>
            <x-input-label for="otp" :value="__('Enter OTP')" />
            <x-text-input 
                wire:model="otp" 
                id="otp" 
                class="block mt-1 w-full text-center text-2xl tracking-widest" 
                :class="$errors->has('otp') ? 'border-red-500 dark:border-red-600 shake' : ''"
                type="text" 
                name="otp" 
                required 
                autofocus 
                maxlength="6"
                pattern="[0-9]{6}"
                placeholder="000000"
            />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter the 6-digit code sent to your email</p>
        </div>

        <div class="flex items-center justify-between mt-4">
            <button 
                type="button"
                wire:click="resendOtp"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-gray-300 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
            >
                {{ __('Resend OTP') }}
            </button>

            <x-primary-button>
                {{ __('Verify & Complete Registration') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-gray-300 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800" 
           href="{{ route('register') }}" 
           wire:navigate>
            {{ __('Back to registration') }}
        </a>
    </div>
</div>
