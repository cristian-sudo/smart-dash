<!-- Mobile Cards -->
<div class="md:hidden space-y-4">
    @forelse($invoices as $invoice)
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg border border-gray-200 dark:border-gray-700">
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
                    <x-invoices.status-badge :status="$invoice->status" />
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
                    <x-invoices.action-buttons :invoice="$invoice" />
                </div>

                @if($previewId === $invoice->id)
                    <div class="mt-4">
                        <x-invoices.preview :invoice="$invoice" />
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