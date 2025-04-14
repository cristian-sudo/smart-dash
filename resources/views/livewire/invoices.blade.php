<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Invoices</h2>
                        <button wire:click="create"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            New Invoice
                        </button>
                    </div>

                    <!-- Invoices Table -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Invoices</h2>
                        </div>

                        <!-- Desktop Table -->
                        <div class="hidden md:block bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Client</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($invoices as $invoice)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                #{{ $invoice->invoice_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $invoice->client->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 
                                                       ($invoice->status === 'overdue' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100' : 
                                                       ($invoice->status === 'sent' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' : 
                                                       'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100')) }}">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                ${{ number_format($invoice->total, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-4">
                                                    <button wire:click="edit({{ $invoice->id }})"
                                                            class="p-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900"
                                                            data-tooltip="Edit">
                                                        <x-icons.edit class="w-5 h-5" />
                                                    </button>
                                                    <button wire:click="togglePreview({{ $invoice->id }})"
                                                            class="p-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900"
                                                            data-tooltip="Preview">
                                                        <x-icons.eye class="w-5 h-5" />
                                                    </button>
                                                    <a href="{{ route('invoices.download', $invoice) }}"
                                                       class="p-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900"
                                                       data-tooltip="Download">
                                                        <x-icons.download class="w-5 h-5" />
                                                    </a>
                                                    @if($invoice->status !== 'paid')
                                                        <button wire:click="markAsPaid({{ $invoice->id }})"
                                                                class="p-2 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 rounded-full hover:bg-green-50 dark:hover:bg-green-900"
                                                                data-tooltip="Mark as Paid">
                                                            <x-icons.check class="w-5 h-5" />
                                                        </button>
                                                    @endif
                                                    <button wire:click="delete({{ $invoice->id }})"
                                                            class="p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900"
                                                            data-tooltip="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                        <x-icons.trash class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @if($previewId === $invoice->id)
                                            <tr>
                                                <td colspan="7" class="px-6 py-4">
                                                    <div class="mt-4">
                                                        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg border border-gray-300 dark:border-gray-600" style="width: 100%; max-width: 210mm; margin: 0 auto; padding: 1.5rem; box-sizing: border-box; aspect-ratio: 210/297;">
                                                            <!-- Header -->
                                                            <div class="flex justify-between items-start mb-8">
                                                                <div>
                                                                    @if(auth()->user()->logo)
                                                                        <img src="{{ auth()->user()->logo_url }}" alt="Company Logo" class="h-20 w-auto mb-4">
                                                                    @endif
                                                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice</h1>
                                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
                                                                </div>
                                                                <div class="text-right">
                                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Date Generated: {{ now()->format('M d, Y') }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Company and Client Info -->
                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
                                                                <div>
                                                                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2">From:</h2>
                                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
                                                                </div>
                                                                <div>
                                                                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2">To:</h2>
                                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->name }}</p>
                                                                    @if($invoice->client->email)
                                                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->email }}</p>
                                                                    @endif
                                                                    @if($invoice->client->phone)
                                                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->phone }}</p>
                                                                    @endif
                                                                    @if($invoice->client->address)
                                                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->address }}</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Invoice Details -->
                                                            <div class="mb-8">
                                                                <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2">Invoice Details:</h2>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">Invoice #: {{ $invoice->invoice_number }}</p>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">Date: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">Status: {{ ucfirst($invoice->status) }}</p>
                                                            </div>

                                                            <!-- Time Logs Table -->
                                                            <div class="mb-8">
                                                                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                                                        <tr>
                                                                            <th class="w-[15%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                                                            <th class="w-[30%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                                                            <th class="w-[10%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hrs</th>
                                                                            <th class="w-[25%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                                                            <th class="w-[20%] px-3 py-2 text-right font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($invoice->timeLogs as $log)
                                                                        <tr>
                                                                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->date->format('M d, Y') }}</td>
                                                                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->service->name }}</td>
                                                                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->hours }}</td>
                                                                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->location }}</td>
                                                                            <td class="px-3 py-2 text-right text-gray-600 dark:text-gray-400">${{ number_format($log->service->calculatePriceForHours($log->hours), 2) }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                                                                        <tr>
                                                                            <td colspan="4" class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Hours:</td>
                                                                            <td class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">{{ $invoice->total_hours }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4" class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Amount:</td>
                                                                            <td class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">${{ number_format($invoice->total, 2) }}</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>

                                                            <!-- Footer -->
                                                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                                                                <p class="text-center text-sm text-gray-600 dark:text-gray-400">Thank you for your business!</p>
                                                                <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2">This is a computer-generated invoice. No signature is required.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No invoices found. Click "New Invoice" to create one.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @forelse($invoices as $invoice)
                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    #{{ $invoice->invoice_number }}
                                                </h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $invoice->client->name }}
                                                </p>
                                            </div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 
                                                   ($invoice->status === 'overdue' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100' : 
                                                   ($invoice->status === 'sent' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' : 
                                                   'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100')) }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </div>

                                        <div class="mt-4 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Due Date</p>
                                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Hours</p>
                                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $invoice->total_hours }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Amount</p>
                                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                                    ${{ number_format($invoice->total, 2) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button wire:click="edit({{ $invoice->id }})"
                                                    class="p-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900"
                                                    data-tooltip="Edit">
                                                <x-icons.edit class="w-5 h-5" />
                                            </button>
                                            <button wire:click="togglePreview({{ $invoice->id }})"
                                                    class="p-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900"
                                                    data-tooltip="Preview">
                                                <x-icons.eye class="w-5 h-5" />
                                            </button>
                                            <a href="{{ route('invoices.download', $invoice) }}"
                                               class="p-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900"
                                               data-tooltip="Download">
                                                <x-icons.download class="w-5 h-5" />
                                            </a>
                                            @if($invoice->status !== 'paid')
                                                <button wire:click="markAsPaid({{ $invoice->id }})"
                                                        class="p-2 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 rounded-full hover:bg-green-50 dark:hover:bg-green-900"
                                                        data-tooltip="Mark as Paid">
                                                    <x-icons.check class="w-5 h-5" />
                                                </button>
                                            @endif
                                            <button wire:click="delete({{ $invoice->id }})"
                                                    class="p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900"
                                                    data-tooltip="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                <x-icons.trash class="w-5 h-5" />
                                            </button>
                                        </div>

                                        @if($previewId === $invoice->id)
                                            <div class="mt-4">
                                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg border border-gray-300 dark:border-gray-600" style="width: 100%; max-width: 210mm; margin: 0 auto; padding: 1.5rem; box-sizing: border-box; aspect-ratio: 210/297;">
                                                    <!-- Header -->
                                                    <div class="flex justify-between items-start mb-8">
                                                        <div>
                                                            @if(auth()->user()->logo)
                                                                <img src="{{ auth()->user()->logo_url }}" alt="Company Logo" class="h-20 w-auto mb-4">
                                                            @endif
                                                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice</h1>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
                                                        </div>
                                                        <div class="text-right">
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">Date Generated: {{ now()->format('M d, Y') }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Company and Client Info -->
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
                                                        <div>
                                                            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2">From:</h2>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
                                                        </div>
                                                        <div>
                                                            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2">To:</h2>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->name }}</p>
                                                            @if($invoice->client->email)
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->email }}</p>
                                                            @endif
                                                            @if($invoice->client->phone)
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->phone }}</p>
                                                            @endif
                                                            @if($invoice->client->address)
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->address }}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Invoice Details -->
                                                    <div class="mb-8">
                                                        <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2">Invoice Details:</h2>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Invoice #: {{ $invoice->invoice_number }}</p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Date: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Status: {{ ucfirst($invoice->status) }}</p>
                                                    </div>

                                                    <!-- Time Logs Table -->
                                                    <div class="mb-8">
                                                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                                <tr>
                                                                    <th class="w-[15%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                                                    <th class="w-[30%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                                                    <th class="w-[10%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hrs</th>
                                                                    <th class="w-[25%] px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                                                    <th class="w-[20%] px-3 py-2 text-right font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($invoice->timeLogs as $log)
                                                                <tr>
                                                                    <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->date->format('M d, Y') }}</td>
                                                                    <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->service->name }}</td>
                                                                    <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->hours }}</td>
                                                                    <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->location }}</td>
                                                                    <td class="px-3 py-2 text-right text-gray-600 dark:text-gray-400">${{ number_format($log->service->calculatePriceForHours($log->hours), 2) }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot class="bg-gray-50 dark:bg-gray-700">
                                                                <tr>
                                                                    <td colspan="4" class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Hours:</td>
                                                                    <td class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">{{ $invoice->total_hours }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Amount:</td>
                                                                    <td class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">${{ number_format($invoice->total, 2) }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <!-- Footer -->
                                                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                                                        <p class="text-center text-sm text-gray-600 dark:text-gray-400">Thank you for your business!</p>
                                                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2">This is a computer-generated invoice. No signature is required.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                                    No invoices found. Click "New Invoice" to create one.
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            {{ $invoices->links() }}
                        </div>
                    </div>

                    <!-- Modal -->
                    <div x-data="{ show: false }"
                         x-cloak
                         x-show="show"
                         x-on:open-modal.window="show = true"
                         x-on:keydown.escape.window="show = false"
                         x-on:close-modal.window="show = false"
                         class="fixed inset-0 z-[100]">
                        
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
                                                {{ $invoiceId ? 'Edit Invoice' : 'Add Invoice' }}
                                            </h3>
                                            <form wire:submit.prevent="save" class="mt-4 space-y-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="client_id" class="block text-base font-medium text-gray-700 dark:text-gray-300">Client</label>
                                                        <select wire:model.live="client_id" id="client_id" required
                                                                class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            <option value="">Select a client</option>
                                                            @foreach($clients as $client)
                                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('client_id') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="date" class="block text-base font-medium text-gray-700 dark:text-gray-300">Date</label>
                                                        <input type="date" wire:model.live="date" id="date" required
                                                               class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                        @error('date') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div>
                                                        <label for="due_date" class="block text-base font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                                                        <input type="date" wire:model.live="due_date" id="due_date" required
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
                                                    <label class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Select Time Logs</label>
                                                    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                                                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                                            @forelse($availableTimeLogs as $log)
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
                                                            @empty
                                                                <li class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                                    No available time logs to select.
                                                                </li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                    @error('selectedTimeLogs') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-4 sticky bottom-0 bg-white dark:bg-gray-800 py-4">
                                                    <button type="button" 
                                                            @click="show = false"
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
                </div>
            </div>
        </div>
    </div>
</div>
