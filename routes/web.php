<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TimeLogController;
use App\Livewire\Invoices;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Invoice;
use App\Livewire\Services;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $timeLogsThisMonth = TimeLog::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get();

        $totalHoursThisMonth = $timeLogsThisMonth->sum('hours');
        $totalEarningsThisMonth = $timeLogsThisMonth->sum(function ($timeLog) {
            return $timeLog->hours * $timeLog->rate;
        });

        // Calculate average hours per day
        $daysInMonth = Carbon::now()->daysInMonth;
        $averageHoursPerDay = $daysInMonth > 0 ? $totalHoursThisMonth / $daysInMonth : 0;

        // Calculate most used service
        $mostUsedService = $timeLogsThisMonth
            ->groupBy('service_id')
            ->map(function ($logs) {
                return [
                    'service' => $logs->first()->service,
                    'hours' => $logs->sum('hours')
                ];
            })
            ->sortByDesc('hours')
            ->first();

        // Get recent time logs
        $recentTimeLogs = TimeLog::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Additional stats
        $totalServices = Service::where('user_id', Auth::id())->count();
        $totalInvoices = Invoice::where('user_id', Auth::id())->count();
        $totalEarnings = TimeLog::where('user_id', Auth::id())
            ->selectRaw('SUM(hours * rate) as total')
            ->value('total') ?? 0;

        // Chart data - last 6 months
        $chartData = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = Carbon::now()->subMonths($monthsAgo);
            $monthLogs = TimeLog::where('user_id', Auth::id())
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->get();
            
            return [
                'month' => $date->format('M Y'),
                'hours' => $monthLogs->sum('hours'),
                'earnings' => $monthLogs->sum(function ($log) {
                    return $log->hours * $log->rate;
                })
            ];
        });

        return view('dashboard', [
            'totalHoursThisMonth' => $totalHoursThisMonth,
            'totalEarningsThisMonth' => $totalEarningsThisMonth,
            'averageHoursPerDay' => $averageHoursPerDay,
            'mostUsedService' => $mostUsedService,
            'recentTimeLogs' => $recentTimeLogs,
            'totalServices' => $totalServices,
            'totalInvoices' => $totalInvoices,
            'totalEarnings' => $totalEarnings,
            'chartData' => $chartData
        ]);
    })->name('dashboard');

    Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');
    Route::get('/services', Services::class)->name('services.index');

    Route::prefix('dashboard')->group(function () {
        // Time Logs Route
        Route::get('/time-logs', function () {
            return view('dashboard.time-logs');
        })->name('time-logs.index');

        // Invoices Route
        Route::get('/invoices', Invoices::class)->name('invoices.index');
        Route::get('/invoices/{invoice}/download', [Invoices::class, 'download'])->name('invoices.download');

        // Services Routes
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
