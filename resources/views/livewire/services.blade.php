<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Services</h2>
                        <button wire:click="create"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            New Service
                        </button>
                    </div>

                    <!-- Services Table -->
                    <div class="mt-8">

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-6">
                            @forelse($services as $service)
                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $service->name }}
                                                </h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    ${{ number_format($service->rate, 2) }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button wire:click="edit({{ $service->id }})"
                                                        class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                        data-tooltip="Edit">
                                                    <x-icons.edit class="w-5 h-5" />
                                                </button>
                                                <button wire:click="delete({{ $service->id }})"
                                                        class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                        data-tooltip="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this service?')">
                                                    <x-icons.trash class="w-5 h-5" />
                                                </button>
                                            </div>
                                        </div>
                                        @if($service->description)
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $service->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                                    No services found. Click "New Service" to create one.
                                </div>
                            @endforelse
                        </div>

                        <!-- Desktop Table -->
                        <div class="hidden md:block bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rate</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($services as $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $service->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                ${{ number_format($service->rate, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $service->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-4">
                                                    <button wire:click="edit({{ $service->id }})"
                                                            class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                            data-tooltip="Edit">
                                                        <x-icons.edit class="w-5 h-5" />
                                                    </button>
                                                    <button wire:click="delete({{ $service->id }})"
                                                            class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                            data-tooltip="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this service?')">
                                                        <x-icons.trash class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No services found. Click "New Service" to create one.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $services->links() }}
                        </div>
                    </div>

                    <!-- Modal -->
                    @if($showModal)
                        <div class="fixed inset-0 z-[100]">
                            <!-- Backdrop -->
                            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" wire:click="closeModal"></div>

                            <!-- Modal Panel -->
                            <div class="fixed inset-0 z-[101] pointer-events-none">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full pointer-events-auto">
                                        <div class="bg-white dark:bg-gray-800 px-6 py-6">
                                            <div class="mt-3">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                                    {{ $editingId ? 'Edit Service' : 'Add Service' }}
                                                </h3>
                                                <form wire:submit.prevent="save" class="mt-4 space-y-4">
                                                    <div>
                                                        <label for="name" class="block text-base font-medium text-gray-700 dark:text-gray-300">Name</label>
                                                        <input type="text" wire:model="name" id="name" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="rate" class="block text-base font-medium text-gray-700 dark:text-gray-300">Rate</label>
                                                        <input type="number" wire:model="rate" id="rate" required step="0.01" min="0"
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('rate') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="description" class="block text-base font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                        <textarea wire:model="description" id="description" rows="4"
                                                                 class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"></textarea>
                                                        @error('description') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-4">
                                                        <button type="button" 
                                                                wire:click="closeModal"
                                                                class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" 
                                                                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                            {{ $editingId ? 'Update' : 'Create' }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 