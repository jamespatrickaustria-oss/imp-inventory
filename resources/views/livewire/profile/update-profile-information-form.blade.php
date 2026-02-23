<section>
    <form wire:submit="updateProfileInformation" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5 dark:text-gray-200">{{ __('Name') }}</label>
            <input wire:model="name" type="text" 
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500/10 shadow-sm transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400" 
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5 dark:text-gray-200">{{ __('Email') }}</label>
            <input wire:model="email" type="email" 
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500/10 shadow-sm transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400" 
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-amber-50 rounded-xl border border-amber-100 dark:bg-amber-500/10 dark:border-amber-500/20">
                    <p class="text-sm text-amber-700 dark:text-amber-200">
                        {{ __('Your email address is unverified.') }}
                        <button wire:click.prevent="sendVerification" class="underline font-bold hover:text-amber-900 transition-colors dark:hover:text-amber-100">
                            {{ __('Re-send verification email.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="py-2.5 px-6 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
                {{ __('Save Changes') }}
            </button>

            <x-action-message class="text-sm text-green-600 font-medium dark:text-emerald-300" on="profile-updated">
                {{ __('Saved successfully.') }}
            </x-action-message>
        </div>
    </form>
</section>