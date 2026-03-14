<div class="p-2 sm:p-4 lg:p-6">
    <div class="mb-5">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Management</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">View and manage system users.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
                    
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-dark-700">
                        <div class="relative max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" 
                                   name="search" 
                                   wire:model.live.debounce.300ms="search" 
                                   id="search" 
                                   class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" 
                                   placeholder="Search users...">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </div>
                        </div>

                        <div class="inline-flex gap-x-2">
                            <a href="{{ route('admin.users.register') }}" 
                                class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95 dark:shadow-blue-900">
                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                Register User
                            </a>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                        <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
                            <tr>
                                <th wire:click="sortByColumn('name')" class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center gap-x-2">
                                        Name
                                        @if ($sortBy === 'name')
                                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                @if ($sortDirection === 'asc')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                @endif
                                            </svg>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="sortByColumn('email')" class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center gap-x-2">
                                        Email
                                        @if ($sortBy === 'email')
                                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                @if ($sortDirection === 'asc')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                @endif
                                            </svg>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="sortByColumn('created_at')" class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center gap-x-2">
                                        Joined
                                        @if ($sortBy === 'created_at')
                                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                @if ($sortDirection === 'asc')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                @endif
                                            </svg>
                                        @endif
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-end text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-x-3">
                                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if ($user->id !== auth()->id())
                                            <button 
                                                wire:click="deleteUser({{ $user->id }})"
                                                wire:confirm="Are you sure you want to delete this user?"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold px-2 inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                Delete
                                            </button>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-xs">Current User</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center">
                                        <p class="text-gray-500 dark:text-gray-400">No users found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center dark:border-dark-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Showing {{ $users->count() }} of {{ $users->total() }} results
                        </span>
                        <div class="flex gap-x-2">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
