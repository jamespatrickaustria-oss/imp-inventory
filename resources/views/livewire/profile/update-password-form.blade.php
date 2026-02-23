<section>
    <form wire:submit="updatePassword" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5 dark:text-gray-200">{{ __('Current Password') }}</label>
            <input wire:model="current_password" type="password" 
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500/10 shadow-sm transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5 dark:text-gray-200">{{ __('New Password') }}</label>
            <input wire:model="password" type="password" 
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500/10 shadow-sm transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5 dark:text-gray-200">{{ __('Confirm Password') }}</label>
            <input wire:model="password_confirmation" type="password" 
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500/10 shadow-sm transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="py-2.5 px-6 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
                {{ __('Update Password') }}
            </button>

            <x-action-message class="text-sm text-green-600 font-medium dark:text-emerald-300" on="password-updated">
                {{ __('Updated.') }}
            </x-action-message>
        </div>
    </form>
</section>