@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-semibold mb-6">Dashboard</h2>

                <!-- Navigation Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Time Logs Card -->
                    <a href="{{ route('time-logs.index') }}" class="block p-6 bg-white dark:bg-gray-700 rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Time Logs</h3>
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">Log your work hours, track services, and generate invoices.</p>
                    </a>

                    <!-- Services Card -->
                    <a href="{{ route('services.index') }}" class="block p-6 bg-white dark:bg-gray-700 rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Services</h3>
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">Manage your services, set default prices, and organize your offerings.</p>
                    </a>

                    <!-- Quick Stats Card -->
                    <div class="block p-6 bg-white dark:bg-gray-700 rounded-lg shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Quick Stats</h3>
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <p class="text-gray-600 dark:text-gray-300">Total Hours This Month: <span class="font-semibold">{{ $totalHoursThisMonth ?? 0 }}</span></p>
                            <p class="text-gray-600 dark:text-gray-300">Total Earnings This Month: <span class="font-semibold">${{ number_format($totalEarningsThisMonth ?? 0, 2) }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @forelse($recentTimeLogs ?? [] as $log)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $log->service->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $log->date->format('M d, Y') }} - {{ $log->hours }} hours</p>
                                </div>
                                <span class="text-indigo-600 dark:text-indigo-400">${{ number_format($log->price, 2) }}</span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-300">No recent activity to show.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
