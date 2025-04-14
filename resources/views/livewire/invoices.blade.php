<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$message" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Invoices</h2>
                        <button wire:click="$set('showModal', true)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create New Invoice
                        </button>
                    </div>

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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time Logs</th>
                                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Hours</th>
                                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($editingId === $invoice->id)
                                            <input type="text" wire:model="name" wire:change="save" class="border-0 bg-transparent focus:ring-0 p-0">
                                        @else
                                            <span class="cursor-pointer" wire:click="edit({{ $invoice->id }})">{{ $invoice->name }}</span>
                                        @endif
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $invoice->timeLogs->count() }} entries
                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                            @foreach($invoice->timeLogs as $log)
                                                {{ $log->service->name }} ({{ $log->date->format('M d, Y') }})<br>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">{{ $invoice->total_hours }}</td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">${{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="togglePreview({{ $invoice->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" data-tooltip="Preview Invoice">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <a href="{{ route('invoices.download', $invoice) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" data-tooltip="Download PDF">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            <button wire:click="delete({{ $invoice->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" data-tooltip="Delete Invoice" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr x-show="$wire.previewId === {{ $invoice->id }}" x-transition>
                                    <td colspan="6" class="px-6 py-4">
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <div class="md:hidden mb-4">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Invoice #</p>
                                                        <p>{{ $invoice->invoice_number }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Time Logs</p>
                                                        <p>{{ $invoice->timeLogs->count() }} entries</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Hours</p>
                                                        <p>{{ $invoice->total_hours }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Amount</p>
                                                        <p>${{ number_format($invoice->total_amount, 2) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('dashboard.invoice', [
                                                'timeLogs' => $invoice->timeLogs,
                                                'totalHours' => $invoice->total_hours,
                                                'totalAmount' => $invoice->total_amount,
                                                'startDate' => $invoice->timeLogs->first() ? $invoice->timeLogs->first()->date : now(),
                                                'endDate' => $invoice->timeLogs->last() ? $invoice->timeLogs->last()->date : now()
                                            ])
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Invoice Modal -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity"
                 aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 role="dialog"
                 aria-modal="true"
                 aria-labelledby="modal-headline">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                            {{ $editingId ? 'Edit Invoice' : 'Create New Invoice' }}
                        </h3>
                        <form wire:submit.prevent="save" class="mt-4 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" wire:model="name" id="name" 
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
                                @error('name') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Time Logs</label>
                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($availableTimeLogs as $log)
                                        <li class="px-4 py-4">
                                            <div class="flex items-center">
                                                <input type="checkbox" wire:model="selectedTimeLogs" value="{{ $log->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $log->date->format('M d, Y') }} - {{ $log->service->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $log->hours }} hours at {{ $log->location }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @error('selectedTimeLogs') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
                                <button type="button" 
                                        @click="$wire.showModal = false"
                                        class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
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
