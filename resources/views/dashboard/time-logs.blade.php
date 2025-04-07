<x-layouts.app :title="__('Time Logs')">
    <script>
        function calculateTotal() {
            const serviceSelect = document.getElementById('service_id');
            const hoursInput = document.getElementById('hours');
            const totalPrice = document.getElementById('totalPrice');
            
            if (!serviceSelect.value) {
                totalPrice.textContent = '$0.00';
                return;
            }
            
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const pricePerHour = parseFloat(selectedOption.dataset.price);
            const hours = parseFloat(hoursInput.value) || 0;
            
            const total = pricePerHour * hours;
            totalPrice.textContent = '$' + total.toFixed(2);
        }

        function editTimeLog(id) {
            fetch(`/dashboard/time-logs/${id}`)
                .then(response => response.json())
                .then(timeLog => {
                    const modal = document.getElementById('newTimeLogModal');
                    const form = modal.querySelector('form');
                    form.action = `/dashboard/time-logs/${id}`;
                    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                    
                    document.getElementById('date').value = timeLog.date;
                    document.getElementById('service_id').value = timeLog.service_id;
                    document.getElementById('hours').value = timeLog.hours;
                    document.getElementById('location').value = timeLog.location || '';
                    document.getElementById('notes').value = timeLog.notes || '';
                    
                    calculateTotal();
                    modal.classList.remove('hidden');
                });
        }

        function resetForm() {
            const modal = document.getElementById('newTimeLogModal');
            const form = modal.querySelector('form');
            form.action = "{{ route('time-logs.store') }}";
            form.reset();
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            document.getElementById('totalPrice').textContent = '$0.00';
        }

        // Initialize when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
            
            // Calculate total when service or hours change
            document.getElementById('service_id').addEventListener('change', calculateTotal);
            document.getElementById('hours').addEventListener('input', calculateTotal);

            // Reset form when opening modal for new time log
            document.querySelector('button[onclick*="newTimeLogModal"]').addEventListener('click', resetForm);
        });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Time Logs</h2>
                        <div class="flex gap-4">
                            <button onclick="document.getElementById('newTimeLogModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                        <a href="{{ route('time-logs.index', ['sort' => $sort === 'desc' ? 'asc' : 'desc']) }}" class="flex items-center">
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
                                        <button onclick="editTimeLog({{ $log->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</button>
                                        <a href="{{ route('time-logs.duplicate', $log) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3">Duplicate</a>
                                        <form action="{{ route('time-logs.destroy', $log->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this time log?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- New Time Log Modal -->
                    <div id="newTimeLogModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                            <div class="mt-3">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Add Time Log</h3>
                                <form action="{{ route('time-logs.store') }}" method="POST" class="mt-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="date">
                                            Date
                                        </label>
                                        <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="service_id">
                                            Service
                                        </label>
                                        <select name="service_id" id="service_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700" required>
                                            <option value="">Select a service</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price_per_hour }}">{{ $service->name }} (${{ number_format($service->price_per_hour, 2) }}/hour)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="hours">
                                            Hours
                                        </label>
                                        <input type="number" name="hours" id="hours" step="0.25" min="0.25" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="location">
                                            Location (Optional)
                                        </label>
                                        <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="notes">
                                            Notes (Optional)
                                        </label>
                                        <textarea name="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                            Total Price
                                        </label>
                                        <div id="totalPrice" class="text-lg font-semibold">$0.00</div>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button type="button" onclick="document.getElementById('newTimeLogModal').classList.add('hidden')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 mr-2">
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
</x-layouts.app> 