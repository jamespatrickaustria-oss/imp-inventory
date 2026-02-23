<section class="space-y-6">
    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="py-2.5 px-6 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-red-600 text-white shadow-lg shadow-red-200 hover:bg-red-700 hover:shadow-none transition-all transform active:scale-95">
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-8">
            <h2 class="text-xl font-bold text-gray-900 tracking-tight dark:text-gray-100">
                {{ __('Are you sure?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500 leading-relaxed dark:text-gray-400">
                {{ __('Once your account is deleted, all data will be permanently removed. Please enter your password to confirm.') }}
            </p>

            <div class="mt-6">
                <input wire:model="password" type="password" 
                    class="py-2.5 px-4 block w-3/4 border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500/10 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-red-400" 
                    placeholder="{{ __('Enter Password') }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" 
                    class="py-2.5 px-5 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-200 dark:hover:bg-dark-surface-secondary">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" 
                    class="py-2.5 px-6 text-sm font-bold rounded-xl bg-red-600 text-white shadow-lg shadow-red-200 hover:bg-red-700 transition-all transform active:scale-95">
                    {{ __('Permanently Delete') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>