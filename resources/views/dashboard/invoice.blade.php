<div class="p-8 bg-white dark:bg-gray-800">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Invoice</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-600 dark:text-gray-400">Date Generated: {{ now()->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Company and Client Info -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">From:</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ config('app.name') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">To:</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Invoice Period:</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
        </div>

        <!-- Time Logs Table -->
        <div class="mb-8">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($timeLogs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $log->date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $log->service->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $log->hours }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $log->location }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-gray-600 dark:text-gray-400">${{ number_format($log->service->calculatePriceForHours($log->hours), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">Total Hours:</td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">{{ $totalHours }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">Total Amount:</td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">${{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <p class="text-center text-gray-600 dark:text-gray-400">Thank you for your business!</p>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2">This is a computer-generated invoice. No signature is required.</p>
        </div>
    </div>
</div> 