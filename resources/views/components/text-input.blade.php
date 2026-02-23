@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-dark-surface-secondary dark:border-dark-600 dark:text-gray-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-400']) }}>
