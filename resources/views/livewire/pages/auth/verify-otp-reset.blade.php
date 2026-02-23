<?php

use App\Services\OtpService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $otp = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $otpVerified = false;

    public function mount()
    {
        // Get email from session
        $this->email = session('reset_email', '');

        // Redirect if no reset session
        if (!$this->email) {
            $this->redirect(route('password.request'), navigate: true);
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(OtpService $otpService): void
    {
        $this->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        // Verify OTP
        if (!$otpService->verify($this->email, $this->otp, 'reset_password')) {
            $this->addError('otp', '❌ Invalid or expired OTP. Please check your code and try again.');
            session()->flash('error', 'The OTP you entered is incorrect or has expired. Please try again or request a new code.');
            $this->otp = ''; // Clear the OTP input
            return;
        }

        $this->otpVerified = true;
        session()->flash('success', '✓ OTP verified successfully! Please enter your new password below.');
    }

    /**
     * Reset password
     */
    public function resetPassword(): void
    {
        if (!$this->otpVerified) {
            $this->addError('password', 'Please verify OTP first.');
            return;
        }

        $this->validate([
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find user and update password
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('password', 'User not found.');
            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        // Clear session
        session()->forget('reset_email');

        // Redirect to login with success message
        session()->flash('status', 'Password reset successfully! Please login with your new password.');
        $this->redirect(route('login'), navigate: true);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(OtpService $otpService): void
    {
        if (!$this->email) {
            $this->addError('otp', 'Session expired. Please start password reset again.');
            session()->flash('error', 'Session expired. Please start password reset again.');
            return;
        }

        if ($otpService->generateAndSend($this->email, 'reset_password')) {
            session()->flash('status', '✓ A new OTP has been sent to your email. Please check your inbox.');
        } else {
            $this->addError('otp', 'Failed to send OTP. Please try again.');
            session()->flash('error', '❌ Failed to send OTP. Please try again later.');
        }
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        @if (!$otpVerified)
            {{ __('We have sent a 6-digit verification code to') }} <strong>{{ $email }}</strong>. 
            {{ __('Please enter the code below to reset your password.') }}
        @else
            {{ __('OTP verified! Please enter your new password.') }}
        @endif
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

    @if (!$otpVerified)
        <!-- OTP Verification Form -->
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
                    {{ __('Verify OTP') }}
                </x-primary-button>
            </div>
        </form>
    @else
        <!-- Password Reset Form -->
        <form wire:submit="resetPassword">
            <!-- Password -->
            <div x-data="{ showPassword: false }">
                <x-input-label for="password" :value="__('New Password')" />

                <div class="relative">
                    <x-text-input 
                        wire:model="password" 
                        id="password" 
                        class="block mt-1 w-full pr-10"
                        ::type="showPassword ? 'text' : 'password'"
                        name="password"
                        required 
                        autofocus
                        autocomplete="new-password" 
                    />

                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4" x-data="{ showPasswordConfirm: false }">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <div class="relative">
                    <x-text-input 
                        wire:model="password_confirmation" 
                        id="password_confirmation" 
                        class="block mt-1 w-full pr-10"
                        ::type="showPasswordConfirm ? 'text' : 'password'"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                    />

                    <button type="button" 
                            @click="showPasswordConfirm = !showPasswordConfirm"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                        <svg x-show="!showPasswordConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPasswordConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    @endif

    <div class="mt-4 text-center">
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-gray-300 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800" 
           href="{{ route('password.request') }}" 
           wire:navigate>
            {{ __('Back to forgot password') }}
        </a>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }
        .shake {
            animation: shake 0.5s;
        }
    </style>
</div>
