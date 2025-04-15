@props(['showModal', 'invoiceId', 'clients', 'companies', 'currentTimeLogs', 'availableTimeLogs', 'availableProducts'])

@if($showModal)
    <div class="fixed inset-0 z-[200] overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" wire:click="closeModal"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-[101] pointer-events-none">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full max-h-[90vh] overflow-y-auto pointer-events-auto">
                    <div class="bg-white dark:bg-gray-800 px-6 py-6">
                        <div class="mt-3">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                {{ $invoiceId ? 'Edit Invoice' : 'Add Invoice' }}
                            </h3>
                            <form wire:submit.prevent="save" class="mt-4 space-y-4">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="client_id" class="block text-base font-medium text-gray-700 dark:text-gray-300">Client</label>
                                        <select wire:model="client_id" id="client_id" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                            <option value="">Select Client</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="company_id" class="block text-base font-medium text-gray-700 dark:text-gray-300">Company (From)</label>
                                        <select wire:model="company_id" id="company_id" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('company_id') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="date" class="block text-base font-medium text-gray-700 dark:text-gray-300">Date</label>
                                        <input type="date" wire:model="date" id="date" required
                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                        @error('date') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="due_date" class="block text-base font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                                        <input type="date" wire:model="due_date" id="due_date" required
                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                        @error('due_date') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="status" class="block text-base font-medium text-gray-700 dark:text-gray-300">Status</label>
                                        <select wire:model.live="status" id="status" required
                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                            <option value="draft">Draft</option>
                                            <option value="sent">Sent</option>
                                            <option value="paid">Paid</option>
                                            <option value="overdue">Overdue</option>
                                        </select>
                                        @error('status') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="notes" class="block text-base font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                        <textarea wire:model="notes" id="notes" rows="4"
                                                 class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"></textarea>
                                        @error('notes') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Time Logs</label>
                                    
                                    <!-- Current Time Logs -->
                                    @if($currentTimeLogs->count() > 0)
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Time Logs</h4>
                                            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach($currentTimeLogs as $log)
                                                        <li class="px-4 py-4">
                                                            <div class="flex items-center justify-between">
                                                                <div class="flex items-center">
                                                                    <input type="checkbox" wire:model="selectedTimeLogs" value="{{ $log->id }}" 
                                                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                                    <div class="ml-3">
                                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                                            {{ $log->date->format('M d, Y') }} - {{ $log->service->name }}
                                                                        </p>
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                            {{ $log->hours }} hours at {{ $log->location }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <button wire:click="removeTimeLog({{ $log->id }})"
                                                                        class="ml-4 p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900">
                                                                    <x-icons.trash class="w-5 h-5" />
                                                                </button>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Available Time Logs -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Time Logs</h4>
                                        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                                @forelse($availableTimeLogs as $log)
                                                    @if(!$currentTimeLogs->contains($log))
                                                        <li class="px-4 py-4">
                                                            <div class="flex items-center">
                                                                <input type="checkbox" wire:model="selectedTimeLogs" value="{{ $log->id }}" 
                                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
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
                                                    @endif
                                                @empty
                                                    <li class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                        No available time logs to select.
                                                    </li>
                                                @endforelse
                                            </ul>
                                        </div>
                                        @error('selectedTimeLogs') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Products</label>
                                    
                                    <!-- Available Products -->
                                    <div class="space-y-4">
                                        @forelse($availableProducts as $product)
                                            <div class="flex items-center space-x-4 p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
                                                <input type="checkbox" 
                                                       wire:model="selectedProducts" 
                                                       value="{{ $product->id }}" 
                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <div class="flex-grow">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $product->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        ${{ number_format($product->price, 2) }} per unit
                                                        <span class="ml-2 {{ $product->stock > 10 ? 'text-green-600 dark:text-green-400' : ($product->stock > 0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                                            ({{ $product->stock }} units available)
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="w-32">
                                                    <input type="number" 
                                                           wire:model.live="productQuantities.{{ $product->id }}" 
                                                           min="1"
                                                           max="{{ $product->stock }}"
                                                           value="1"
                                                           placeholder="Quantity"
                                                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-sm"
                                                           :disabled="!$wire.selectedProducts.includes('{{ $product->id }}') || {{ $product->stock }} === 0"
                                                           x-bind:class="{
                                                               'bg-gray-100 dark:bg-gray-600': !$wire.selectedProducts.includes('{{ $product->id }}') || {{ $product->stock }} === 0,
                                                               'border-red-300 dark:border-red-600': $wire.productQuantities['{{ $product->id }}'] > {{ $product->stock }}
                                                           }">
                                                    @if(isset($productQuantities[$product->id]) && $productQuantities[$product->id] > $product->stock)
                                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                                                            Exceeds available stock
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 dark:text-gray-400 p-4">
                                                No products available. Add products in the Products section first.
                                            </p>
                                        @endforelse
                                    </div>
                                    @error('selectedProducts') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                    @error('productQuantities') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-6 flex justify-end space-x-4 sticky bottom-0 bg-white dark:bg-gray-800 py-4">
                                    <button type="button" 
                                            wire:click="closeModal"
                                            class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        {{ $invoiceId ? 'Update' : 'Create' }}
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