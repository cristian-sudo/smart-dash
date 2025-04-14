<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Time Logs</h2>
                        <button wire:click="$set('showModal', true)"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('New Time Log') }}
                        </button>
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
                                @forelse($timeLogs as $timeLog)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $timeLog->date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4">{{ $timeLog->service->name }}</td>
                                    <td class="px-6 py-4 text-right">{{ number_format($timeLog->hours, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($timeLog->rate, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($timeLog->hours * $timeLog->rate, 2) }}</td>
                                    <td class="px-6 py-4">{{ $timeLog->location }}</td>
                                    <td class="px-6 py-4">{{ $timeLog->notes }}</td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="edit({{ $timeLog->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" data-tooltip="Edit Time Log">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $timeLog->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" data-tooltip="Delete Time Log" onclick="return confirm('Are you sure you want to delete this time log?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No time logs found. Click "New Time Log" to create one.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $timeLogs->links() }}
                    </div>

                    <!-- New Time Log Modal -->
                    <div x-data="{ show: @entangle('showModal') }"
                         x-show="show"
                         x-on:click.away="$wire.showModal = false"
                         x-on:keydown.escape.window="$wire.showModal = false"
                         class="fixed inset-0 z-50"
                         style="display: none;">
                        <!-- Backdrop -->
                        <div x-show="show"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"
                             @click="$wire.showModal = false">
                        </div>

                        <div class="fixed inset-0 overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen p-4">
                                <div x-show="show"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-2xl sm:w-full">
                                    <div class="bg-white dark:bg-gray-800 px-6 py-6">
                                        <div class="mt-3">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                                {{ $timeLogId ? 'Edit Time Log' : 'Add Time Log' }}
                                            </h3>
                                            <form wire:submit.prevent="save" class="mt-4 space-y-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="date" class="block text-base font-medium text-gray-700 dark:text-gray-300">Date</label>
                                                        <input type="date" wire:model.live="date" id="date" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('date') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="service_id" class="block text-base font-medium text-gray-700 dark:text-gray-300">Service</label>
                                                        <select wire:model.live="service_id" id="service_id" required
                                                                class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            <option value="">Select a service</option>
                                                            @foreach($services as $service)
                                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('service_id') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="hours" class="block text-base font-medium text-gray-700 dark:text-gray-300">Hours</label>
                                                        <input type="number" wire:model.live="hours" id="hours" step="0.25" min="0.25" max="24" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('hours') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    @if($service_id)
                                                        <div>
                                                            <label class="block text-base font-medium text-gray-700 dark:text-gray-300">Rate per Hour</label>
                                                            <div class="mt-2 text-lg text-gray-900 dark:text-gray-100 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                                                ${{ number_format($selectedServiceRate, 2) }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="md:col-span-2">
                                                        <label for="location" class="block text-base font-medium text-gray-700 dark:text-gray-300">Location</label>
                                                        <div class="mt-2 relative">
                                                            <select wire:model.live="selectedLocation" id="location-select" 
                                                                    class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                                <option value="">Select a saved location or type a new one</option>
                                                                @foreach($savedLocations as $location)
                                                                    <option value="{{ $location->name }}">{{ $location->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" wire:model.live="location" id="location"
                                                                   class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"
                                                                   placeholder="Or type a new location">
                                                        </div>
                                                        @error('location') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="md:col-span-2">
                                                        <label for="notes" class="block text-base font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                                        <textarea wire:model="notes" id="notes" rows="4"
                                                                  class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"></textarea>
                                                        @error('notes') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <button type="button" 
                                                            @click="$wire.showModal = false"
                                                            class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" 
                                                            class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        {{ $timeLogId ? 'Update' : 'Create' }}
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
