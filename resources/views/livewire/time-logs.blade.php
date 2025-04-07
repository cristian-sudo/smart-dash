<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <div x-data="{ 
                show: @entangle('showNotification'),
                init() {
                    this.$watch('show', (value) => {
                        if (value) {
                            setTimeout(() => {
                                this.show = false;
                                $wire.showNotification = false;
                                $wire.notificationMessage = '';
                            }, 3000);
                        }
                    });
                }
            }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="fixed right-4 top-4 z-50 w-80 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg" 
            role="alert">
                <span class="block sm:inline">{{ $notificationMessage }}</span>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Time Logs</h2>
                        <div class="flex gap-4">
                            <button wire:click="$set('showModal', true)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Time Log
                            </button>
                        </div>
                    </div>

                    <!-- Time Logs Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <button wire:click="toggleSort" class="flex items-center">
                                            Date
                                            @if($sort === 'desc')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @endif
                                        </button>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rate/Hour</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notes</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($timeLogs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->hours }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($log->service->price_per_hour, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($log->service->calculatePriceForHours($log->hours), 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->location }}</td>
                                    <td class="px-6 py-4">{{ $log->notes }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button wire:click="edit({{ $log->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</button>
                                        <button wire:click="duplicate({{ $log->id }})" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3">Duplicate</button>
                                        <button wire:click="delete({{ $log->id }})" onclick="return confirm('Are you sure you want to delete this time log?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $timeLogs->links() }}
                    </div>

                    <!-- New Time Log Modal -->
                    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full" style="display: none;">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                            <div class="mt-3">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    {{ $editingId ? 'Edit Time Log' : 'Add Time Log' }}
                                </h3>
                                <form wire:submit.prevent="save" class="mt-4">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="date">
                                            Date
                                        </label>
                                        <input type="date" wire:model="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700" required>
                                        @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="service_id">
                                            Service
                                        </label>
                                        <select wire:model="service_id" id="service_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700" required>
                                            <option value="">Select a service</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price_per_hour }}">{{ $service->name }} (${{ number_format($service->price_per_hour, 2) }}/hour)</option>
                                            @endforeach
                                        </select>
                                        @error('service_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="hours">
                                            Hours
                                        </label>
                                        <input type="number" wire:model="hours" id="hours" step="0.25" min="0.25" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700" required>
                                        @error('hours') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="location">
                                            Location (Optional)
                                        </label>
                                        <input type="text" wire:model="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700">
                                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="notes">
                                            Notes (Optional)
                                        </label>
                                        <textarea wire:model="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700"></textarea>
                                        @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                            Total Price
                                        </label>
                                        <div class="text-lg font-semibold">${{ number_format($this->calculateTotal(), 2) }}</div>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button type="button" wire:click="$set('showModal', false)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 mr-2">
                                            Cancel
                                        </button>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save
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

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (data) => {
                alert(data.message);
            });
        });
    </script>
    @endpush
</div>
