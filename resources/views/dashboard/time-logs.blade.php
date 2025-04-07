@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Time Logs</h2>
                    <button onclick="document.getElementById('timeLogModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Log Time
                    </button>
                </div>

                <!-- Calendar -->
                <div class="mb-8">
                    <div id="calendar" class="bg-white dark:bg-gray-700 rounded-lg shadow"></div>
                </div>

                <!-- Time Logs List -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4">Recent Time Logs</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($timeLogs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->hours }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($log->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Invoice Generation -->
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Generate Invoice</h3>
                    <form action="{{ route('time-logs.generate-invoice') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500">
                            </div>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Generate PDF Invoice
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Time Log Modal -->
<div id="timeLogModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Log Time</h3>
            <form action="{{ route('time-logs.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                    </div>
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service</label>
                        <select name="service_id" id="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                            <option value="">Select a service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hours</label>
                        <input type="number" name="hours" id="hours" step="0.5" min="0.5" max="24" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                        <input type="text" name="location" id="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500"></textarea>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('timeLogModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/time-logs/calendar',
            dateClick: function(info) {
                document.getElementById('date').value = info.dateStr;
                document.getElementById('timeLogModal').classList.remove('hidden');
            }
        });
        calendar.render();
    });
</script>
@endpush
@endsection 