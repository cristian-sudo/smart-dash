<x-layouts.app :title="__('Invoices')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Invoices</h2>
                        <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create New Invoice
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <a href="{{ route('invoices.index', ['sort' => $sort === 'desc' ? 'asc' : 'desc']) }}" class="flex items-center">
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
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Hours</th>
                                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoices as $invoice)
                                <tr class="{{ request('preview') == $invoice->id ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('invoices.update', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $invoice->name }}" class="border-0 bg-transparent focus:ring-0 p-0" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">{{ $invoice->start_date->format('Y-m-d') }} to {{ $invoice->end_date->format('Y-m-d') }}</td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">{{ $invoice->total_hours }}</td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">${{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="togglePreview({{ $invoice->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Toggle Preview">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <a href="{{ route('invoice.download', ['start_date' => $invoice->start_date->format('Y-m-d'), 'end_date' => $invoice->end_date->format('Y-m-d')]) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Download">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="preview-{{ $invoice->id }}" class="{{ request('preview') == $invoice->id ? '' : 'hidden' }}">
                                    <td colspan="6" class="px-6 py-4">
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <div class="md:hidden mb-4">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Period</p>
                                                        <p>{{ $invoice->start_date->format('Y-m-d') }} to {{ $invoice->end_date->format('Y-m-d') }}</p>
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
                                                'startDate' => $invoice->start_date,
                                                'endDate' => $invoice->end_date
                                            ])
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown Portal -->
    <div id="dropdown-portal" class="fixed z-50"></div>

    <script>
        function togglePreview(id) {
            const preview = document.getElementById(`preview-${id}`);
            const row = preview.previousElementSibling;
            
            if (preview.classList.contains('hidden')) {
                preview.classList.remove('hidden');
                row.classList.add('bg-indigo-50', 'dark:bg-indigo-900');
            } else {
                preview.classList.add('hidden');
                row.classList.remove('bg-indigo-50', 'dark:bg-indigo-900');
            }
        }

        // Auto-open preview if specified in URL
        document.addEventListener('DOMContentLoaded', function() {
            const previewId = new URLSearchParams(window.location.search).get('preview');
            if (previewId) {
                togglePreview(previewId);
            }
        });
    </script>
</x-layouts.app> 