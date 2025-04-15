<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Clients</h2>
                        <button x-on:click="$dispatch('open-modal')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('New Client') }}
                        </button>
                    </div>

                    <!-- Clients Table -->
                    <div class="overflow-x-auto">
                        <!-- Mobile View -->
                        <div class="md:hidden space-y-6">
                            @forelse($clients as $client)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $client->name }}
                                        </div>
                                        <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                            {{ $client->email }}
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        {{ $client->phone }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        {{ $client->address }}, {{ $client->city }}, {{ $client->state }} {{ $client->zip }}
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <div class="flex space-x-2 relative z-[50]">
                                            <button wire:click="edit({{ $client->id }})"
                                                    class="p-1 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                                                    data-tooltip="Edit">
                                                <x-icons.edit />
                                            </button>
                                            <button wire:click="delete({{ $client->id }})"
                                                    class="p-1 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400"
                                                    data-tooltip="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this client?')">
                                                <x-icons.trash />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    No clients found. Click "New Client" to create one.
                                </div>
                            @endforelse
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden sm:block">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Address</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($clients as $client)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $client->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $client->email }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $client->phone }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $client->address }}, {{ $client->city }}, {{ $client->state }} {{ $client->zip }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right space-x-2">
                                            <div class="flex items-center justify-end space-x-2">
                                                <div class="flex space-x-2 relative z-[50]">
                                                    <button wire:click="edit({{ $client->id }})"
                                                            class="p-1 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                                                            data-tooltip="Edit">
                                                        <x-icons.edit />
                                                    </button>
                                                    <button wire:click="delete({{ $client->id }})"
                                                            class="p-1 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400"
                                                            data-tooltip="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this client?')">
                                                        <x-icons.trash />
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No clients found. Click "New Client" to create one.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>

                    <!-- New Client Modal -->
                    <div x-data="{ show: false }"
                         x-cloak
                         x-show="show"
                         x-on:open-modal.window="show = true"
                         x-on:keydown.escape.window="show = false"
                         x-on:close-modal.window="show = false"
                         class="fixed inset-0 z-[100]"
                         style="display: none;">
                        
                        <!-- Backdrop -->
                        <div x-show="show"
                             x-transition.opacity.duration.300ms
                             class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"
                             @click="show = false">
                        </div>

                        <!-- Modal Panel -->
                        <div class="fixed inset-0 z-[101] pointer-events-none">
                            <div class="flex items-center justify-center min-h-screen p-4">
                                <div x-show="show"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full max-h-[90vh] overflow-y-auto pointer-events-auto"
                                     @click.away="show = false">
                                    
                                    <div class="bg-white dark:bg-gray-800 px-6 py-6">
                                        <div class="mt-3">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                                {{ $clientId ? 'Edit Client' : 'Add Client' }}
                                            </h3>
                                            <form wire:submit.prevent="save" class="mt-4 space-y-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="name" class="block text-base font-medium text-gray-700 dark:text-gray-300">Name</label>
                                                        <input type="text" wire:model.live="name" id="name" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="email" class="block text-base font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                        <input type="email" wire:model.live="email" id="email"
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('email') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="phone" class="block text-base font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                                        <input type="text" wire:model.live="phone" id="phone"
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('phone') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="address" class="block text-base font-medium text-gray-700 dark:text-gray-300">Address <span class="text-red-500">*</span></label>
                                                        <input type="text" wire:model.live="address" id="address" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('address') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="city" class="block text-base font-medium text-gray-700 dark:text-gray-300">City <span class="text-red-500">*</span></label>
                                                        <input type="text" wire:model.live="city" id="city" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('city') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="county" class="block text-base font-medium text-gray-700 dark:text-gray-300">County/State <span class="text-red-500">*</span></label>
                                                        <input type="text" wire:model.live="state" id="county" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('state') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="postcode" class="block text-base font-medium text-gray-700 dark:text-gray-300">Postcode/ZIP <span class="text-red-500">*</span></label>
                                                        <input type="text" wire:model.live="zip" id="postcode" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('zip') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="country" class="block text-base font-medium text-gray-700 dark:text-gray-300">Country <span class="text-red-500">*</span></label>
                                                        <input type="text" wire:model.live="country" id="country" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('country') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="md:col-span-2">
                                                        <label for="notes" class="block text-base font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                                        <textarea wire:model="notes" id="notes" rows="4"
                                                                  class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"></textarea>
                                                        @error('notes') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-4 sticky bottom-0 bg-white dark:bg-gray-800 py-4">
                                                    <button type="button" 
                                                            @click="show = false"
                                                            class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" 
                                                            class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        {{ $clientId ? 'Update' : 'Create' }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 