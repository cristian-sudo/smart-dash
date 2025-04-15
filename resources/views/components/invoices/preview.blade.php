@props(['invoice'])

<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg border border-gray-300 dark:border-gray-600" 
     style="width: 100%; max-width: 210mm; margin: 0 auto; padding: 1rem; box-sizing: border-box; transform-origin: top center; transform: scale(0.8); @media (min-width: 640px) { transform: scale(1); }">
    <!-- Color Strip -->
    @if($invoice->company && $invoice->company->color)
        <div class="h-2 w-full mb-4" style="background-color: {{ $invoice->company->color }};"></div>
    @endif
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start mb-4 sm:mb-8">
        <div>
            @if($invoice->company && $invoice->company->logo)
                <img src="{{ Storage::url($invoice->company->logo) }}" alt="Company Logo" class="h-12 sm:h-20 w-auto mb-2 sm:mb-4">
            @endif
            <h1 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">Invoice</h1>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->company ? $invoice->company->name : config('app.name') }}</p>
        </div>
        <div class="text-right mt-4 sm:mt-0">
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Date Generated: {{ now()->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Company, Client, and Invoice Info -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-8 mb-4 sm:mb-8">
        <div>
            <h2 class="text-xs sm:text-base font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">From:</h2>
            @if($invoice->company)
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->company->name }}</p>
                @if($invoice->company->email)
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->company->email }}</p>
                @endif
                @if($invoice->company->phone)
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->company->phone }}</p>
                @endif
                @if($invoice->company->address)
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->company->address }}</p>
                @endif
                @if($invoice->company->tax_number)
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Tax Number: {{ $invoice->company->tax_number }}</p>
                @endif
                @if($invoice->company->registration_number)
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Reg Number: {{ $invoice->company->registration_number }}</p>
                @endif
            @else
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
            @endif
        </div>
        <div>
            <h2 class="text-xs sm:text-base font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">To:</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->name }}</p>
            @if($invoice->client->email)
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->email }}</p>
            @endif
            @if($invoice->client->phone)
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->phone }}</p>
            @endif
            @if($invoice->client->address)
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->address }}</p>
            @endif
        </div>
        <div>
            <h2 class="text-xs sm:text-base font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">Invoice Details:</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Invoice #: {{ $invoice->invoice_number }}</p>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Date: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Status: {{ ucfirst($invoice->status) }}</p>
        </div>
    </div>

    <!-- Time Logs Table -->
    <div class="mb-4 sm:mb-8 overflow-x-auto">
        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm min-w-[600px]">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="w-[15%] px-2 sm:px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="w-[30%] px-2 sm:px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                    <th class="w-[10%] px-2 sm:px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hrs</th>
                    <th class="w-[25%] px-2 sm:px-3 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                    <th class="w-[20%] px-2 sm:px-3 py-2 text-right font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->timeLogs as $log)
                <tr>
                    <td class="px-2 sm:px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->date->format('M d, Y') }}</td>
                    <td class="px-2 sm:px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->service->name }}</td>
                    <td class="px-2 sm:px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->hours }}</td>
                    <td class="px-2 sm:px-3 py-2 text-gray-600 dark:text-gray-400">{{ $log->location }}</td>
                    <td class="px-2 sm:px-3 py-2 text-right text-gray-600 dark:text-gray-400">${{ number_format($log->service->calculatePriceForHours($log->hours), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <td colspan="4" class="px-2 sm:px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Hours:</td>
                    <td class="px-2 sm:px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">{{ $invoice->total_hours }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-2 sm:px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">Total Amount:</td>
                    <td class="px-2 sm:px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Footer -->
    <div class="mt-4 sm:mt-8 pt-4 sm:pt-8 border-t border-gray-200 dark:border-gray-700">
        <p class="text-center text-xs sm:text-sm text-gray-600 dark:text-gray-400">Thank you for your business!</p>
        <p class="text-center text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 sm:mt-2">This is a computer-generated invoice. No signature is required.</p>
    </div>
</div> 