<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-dark-surface-secondary dark:border-dark-600 dark:text-gray-100 dark:hover:bg-dark-surface-tertiary dark:focus:ring-offset-dark-surface disabled:opacity-25 transition ease-in-out duration-150 tap-feedback']) }}>
    {{ $slot }}
</button>
