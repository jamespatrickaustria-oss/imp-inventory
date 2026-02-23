<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight dark:text-gray-100">
                {{ __('Settings') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Manage your account information and security settings.</p>
        </div>
    </div>

    <div class="space-y-6">
        
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-6 bg-gray-50/50 border-b md:border-b-0 md:border-r border-gray-100 dark:bg-dark-surface-tertiary/60 dark:border-dark-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">{{ __('Public Profile') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update your email and basic account info.</p>
                </div>
                <div class="p-6 md:col-span-2">
                    <div class="max-w-xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-6 bg-gray-50/50 border-b md:border-b-0 md:border-r border-gray-100 dark:bg-dark-surface-tertiary/60 dark:border-dark-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">{{ __('Security') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Change your password and secure your account.</p>
                </div>
                <div class="p-6 md:col-span-2">
                    <div class="max-w-xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-red-50 shadow-sm rounded-2xl overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-6 bg-red-50/30 border-b md:border-b-0 md:border-r border-red-50 dark:bg-red-500/10 dark:border-red-500/20">
                    <h3 class="text-base font-bold text-red-900 dark:text-red-200">{{ __('Danger Zone') }}</h3>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-300">Delete all your data and close your account permanently.</p>
                </div>
                <div class="p-6 md:col-span-2">
                    <div class="max-w-xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>