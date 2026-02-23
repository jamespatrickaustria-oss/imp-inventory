<div class="p-2 sm:p-4 lg:p-6 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Stock Movement Report</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Track and analyze all stock movements within a selected date range.</p>
    </div>

    <!-- Date Range and Filters Section -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 dark:bg-dark-surface-secondary dark:border-dark-700">
        <form wire:submit.prevent="generateReport" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Start Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        wire:model.live="startDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                        required
                    >
                    @error('startDate') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        End Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        wire:model.live="endDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                        required
                    >
                    @error('endDate') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Movement Type Filter -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        Movement Type
                    </label>
                    <select
                        wire:model.live="movementType"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                    >
                        <option value="">All</option>
                        <option value="stock_in">Stock In</option>
                        <option value="stock_out">Stock Out</option>
                    </select>
                </div>

                <!-- Product Filter -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        Product
                    </label>
                    <select
                        wire:model.live="productId"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                    >
                        <option value="">All Products</option>
                        @foreach($products as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Generate Button -->
                <div class="flex items-end">
                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 transition-colors"
                    >
                        Generate Report
                    </button>
                </div>
            </div>
        </form>

        <!-- Action Buttons -->
        <div class="flex gap-2 mt-4">
            <button
                wire:click="resetFilters"
                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors"
            >
                Reset Filters
            </button>
            <button
                wire:click="exportAsCSV"
                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 transition-colors"
                title="Export movements from {{ $startDate }} to {{ $endDate }} as CSV"
            >
                📥 Export as CSV
            </button>
        </div>
        
        <!-- Export Info - Real-time Update -->
        <div wire:key="export-info-{{ $startDate }}-{{ $endDate }}" class="transition-all duration-300">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 flex items-center gap-2">
                <span>📋 Export will include all movements from</span>
                <span class="font-semibold text-blue-600 dark:text-blue-400">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</span>
                <span>to</span>
                <span class="font-semibold text-blue-600 dark:text-blue-400">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
            </p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 dark:bg-dark-surface-secondary dark:border-dark-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Total Movements</p>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totals['total_movements'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 dark:bg-dark-surface-secondary dark:border-dark-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Stock In Entries</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totals['total_stock_in'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Qty: {{ $totals['total_quantity_in'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 dark:bg-dark-surface-secondary dark:border-dark-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Stock Out Entries</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $totals['total_stock_out'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Qty: {{ $totals['total_quantity_out'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 dark:bg-dark-surface-secondary dark:border-dark-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Net Change</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                {{ $totals['total_quantity_in'] - $totals['total_quantity_out'] }}
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 dark:bg-dark-surface-secondary dark:border-dark-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Products Affected</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ count($summary) }}</p>
        </div>
    </div>

    <!-- Summary Table -->
    @if(!empty($summary))
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Product Summary</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
                        <tr>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Product</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">SKU</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Stock In</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Stock Out</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Net Change</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Movements</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach($summary as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item['product_name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $item['sku'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        +{{ $item['total_in'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        -{{ $item['total_out'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($item['net_change'] > 0)
                                            bg-green-50 text-green-700 dark:bg-green-900 dark:text-green-200
                                        @elseif($item['net_change'] < 0)
                                            bg-red-50 text-red-700 dark:bg-red-900 dark:text-red-200
                                        @else
                                            bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200
                                        @endif">
                                        {{ $item['net_change'] > 0 ? '+' : '' }}{{ $item['net_change'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $item['movements_count'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Detailed Movements Table -->
    @if($movements->count() > 0)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Detailed Movements</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
                        <tr>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Date & Time</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Product</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Type</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Quantity</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Reason</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Made By</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Reference</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach($movements as $movement)
                            <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $movement->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $movement->product->name ?? 'Unknown' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($movement->isStockIn())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Stock In
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Stock Out
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $movement->quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                    <span title="{{ $movement->reason ?? 'N/A' }}">
                                        {{ $movement->reason ? Str::limit($movement->reason, 30) : 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $movement->user->name ?? 'System' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    @if($movement->reference_id)
                                        <span class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">
                                            {{ $movement->reference_type }} #{{ $movement->reference_id }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-dark-700">
                {{ $movements->links() }}
            </div>
        </div>
    @else
        <div class="bg-white border border-dashed border-gray-200 rounded-xl p-6 text-center text-sm text-gray-500 dark:bg-dark-surface-secondary dark:border-dark-700 dark:text-gray-400">
            No stock movements found for the selected date range and filters.
        </div>
    @endif
</div>
