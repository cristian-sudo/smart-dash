<x-layouts.app :title="__('Dashboard')">
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-4 sm:mb-8">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="mt-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Here's what's happening with your business today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4 mb-4 sm:mb-8">
                <!-- Total Hours This Month -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-3 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2 sm:p-3">
                                <x-icons.clock />
                            </div>
                            <div class="ml-3 sm:ml-5">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Total Hours</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalHoursThisMonth, 1) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Earnings This Month -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-3 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-2 sm:p-3">
                                <x-icons.money />
                            </div>
                            <div class="ml-3 sm:ml-5">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Earnings</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($totalEarningsThisMonth, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Hours Per Day -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-3 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-2 sm:p-3">
                                <x-icons.chart />
                            </div>
                            <div class="ml-3 sm:ml-5">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Hours/Day</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($averageHoursPerDay, 1) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Most Used Service -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-3 sm:p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-2 sm:p-3">
                                <x-icons.service />
                            </div>
                            <div class="ml-3 sm:ml-5">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Top Service</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900 dark:text-white">
                                    @if($mostUsedService)
                                        {{ $mostUsedService['service']->name }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-4 sm:gap-6 mb-4 sm:mb-8">
                <!-- Hours Calendar -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-3 sm:p-5">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-2 sm:mb-4">Monthly Hours</h3>
                        <div class="mb-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $currentMonth }}</div>
                        <div class="grid grid-cols-7 gap-0.5 sm:gap-1">
                            @php
                                $maxHours = $dailyData->max('hours');
                                $firstDayOfWeek = $startOfMonth->dayOfWeek;
                            @endphp
                            
                            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                <div class="text-center text-[10px] sm:text-xs font-medium text-gray-500 dark:text-gray-400 py-0.5 sm:py-1">{{ substr($day, 0, 1) }}</div>
                            @endforeach
                            
                            @for($i = 0; $i < $firstDayOfWeek; $i++)
                                <div class="aspect-square"></div>
                            @endfor
                            
                            @foreach($dailyData as $day)
                                @php
                                    $intensity = $maxHours > 0 ? min(100, ($day['hours'] / $maxHours) * 100) : 0;
                                    $bgColor = match(true) {
                                        $intensity > 75 => 'bg-indigo-600',
                                        $intensity > 50 => 'bg-indigo-500',
                                        $intensity > 25 => 'bg-indigo-400',
                                        $intensity > 0 => 'bg-indigo-300',
                                        default => 'bg-gray-100 dark:bg-gray-700'
                                    };
                                    $textColor = $intensity > 0 ? 'text-white' : 'text-gray-900 dark:text-white';
                                @endphp
                                <div class="aspect-square relative group">
                                    <div class="w-full h-full {{ $bgColor }} rounded flex items-center justify-center text-[10px] sm:text-sm {{ $textColor }} font-medium">
                                        {{ $day['day'] }}
                                    </div>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 sm:mb-2 hidden group-hover:block bg-gray-900 text-white text-[10px] sm:text-xs rounded py-0.5 sm:py-1 px-1 sm:px-2">
                                        {{ number_format($day['hours'], 1) }} hours
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Earnings Calendar -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-3 sm:p-5">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-2 sm:mb-4">Monthly Earnings</h3>
                        <div class="mb-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $currentMonth }}</div>
                        <div class="grid grid-cols-7 gap-0.5 sm:gap-1">
                            @php
                                $maxEarnings = $dailyData->max('earnings');
                                $firstDayOfWeek = $startOfMonth->dayOfWeek;
                            @endphp
                            
                            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                <div class="text-center text-[10px] sm:text-xs font-medium text-gray-500 dark:text-gray-400 py-0.5 sm:py-1">{{ substr($day, 0, 1) }}</div>
                            @endforeach
                            
                            @for($i = 0; $i < $firstDayOfWeek; $i++)
                                <div class="aspect-square"></div>
                            @endfor
                            
                            @foreach($dailyData as $day)
                                @php
                                    $intensity = $maxEarnings > 0 ? min(100, ($day['earnings'] / $maxEarnings) * 100) : 0;
                                    $bgColor = match(true) {
                                        $intensity > 75 => 'bg-emerald-600',
                                        $intensity > 50 => 'bg-emerald-500',
                                        $intensity > 25 => 'bg-emerald-400',
                                        $intensity > 0 => 'bg-emerald-300',
                                        default => 'bg-gray-100 dark:bg-gray-700'
                                    };
                                    $textColor = $intensity > 0 ? 'text-white' : 'text-gray-900 dark:text-white';
                                @endphp
                                <div class="aspect-square relative group">
                                    <div class="w-full h-full {{ $bgColor }} rounded flex items-center justify-center text-[10px] sm:text-sm {{ $textColor }} font-medium">
                                        {{ $day['day'] }}
                                    </div>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 sm:mb-2 hidden group-hover:block bg-gray-900 text-white text-[10px] sm:text-xs rounded py-0.5 sm:py-1 px-1 sm:px-2">
                                        ${{ number_format($day['earnings'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Time Logs -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex justify-between items-center mb-2 sm:mb-4">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Recent Time Logs</h3>
                        <a href="{{ route('time-logs.index') }}" class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            View All
                        </a>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="sm:hidden space-y-3">
                        @foreach($recentTimeLogs as $log)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="text-xs font-medium text-gray-900 dark:text-white">
                                        {{ $log->date->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs font-medium text-indigo-600 dark:text-indigo-400">
                                        ${{ number_format($log->hours * $log->rate, 2) }}
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                    {{ $log->service->name }}
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ number_format($log->hours, 1) }} hours</span>
                                    <span>{{ $log->location ?? 'N/A' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden sm:block overflow-x-auto -mx-3 sm:-mx-5">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentTimeLogs as $log)
                                        <tr>
                                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $log->date->format('M d, Y') }}
                                            </td>
                                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $log->service->name }}
                                            </td>
                                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ number_format($log->hours, 1) }}
                                            </td>
                                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $log->location ?? 'N/A' }}
                                            </td>
                                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm text-right text-gray-900 dark:text-gray-100">
                                                ${{ number_format($log->hours * $log->rate, 2) }}
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
    </div>
</x-layouts.app>
