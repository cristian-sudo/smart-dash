<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $timeLogsThisMonth = TimeLog::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get();

        $totalHoursThisMonth = $timeLogsThisMonth->sum('hours');
        $totalEarningsThisMonth = $timeLogsThisMonth->sum(function ($timeLog) {
            return $timeLog->hours * $timeLog->rate;
        });

        $daysInMonth = Carbon::now()->daysInMonth;
        $averageHoursPerDay = $daysInMonth > 0 ? $totalHoursThisMonth / $daysInMonth : 0;

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

        $recentTimeLogs = TimeLog::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $dailyData = collect();
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $dayLogs = TimeLog::where('user_id', Auth::id())
                ->whereDate('date', $date)
                ->get();
            
            $dailyData->push([
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('j'),
                'hours' => $dayLogs->sum('hours'),
                'earnings' => $dayLogs->sum(function ($log) {
                    return $log->hours * $log->rate;
                })
            ]);
        }

        $maxHours = $dailyData->max('hours');
        $maxEarnings = $dailyData->max('earnings');

        // Prepare calendar data
        $hoursCalendar = $dailyData->map(function ($day) use ($maxHours) {
            $intensity = $maxHours > 0 ? min(100, ($day['hours'] / $maxHours) * 100) : 0;
            return [
                'day' => $day['day'],
                'hours' => $day['hours'],
                'bgColor' => match(true) {
                    $intensity > 75 => 'bg-indigo-600',
                    $intensity > 50 => 'bg-indigo-500',
                    $intensity > 25 => 'bg-indigo-400',
                    $intensity > 0 => 'bg-indigo-300',
                    default => 'bg-gray-100 dark:bg-gray-700'
                },
                'textColor' => $intensity > 0 ? 'text-white' : 'text-gray-900 dark:text-white'
            ];
        });

        $earningsCalendar = $dailyData->map(function ($day) use ($maxEarnings) {
            $intensity = $maxEarnings > 0 ? min(100, ($day['earnings'] / $maxEarnings) * 100) : 0;
            return [
                'day' => $day['day'],
                'earnings' => $day['earnings'],
                'bgColor' => match(true) {
                    $intensity > 75 => 'bg-emerald-600',
                    $intensity > 50 => 'bg-emerald-500',
                    $intensity > 25 => 'bg-emerald-400',
                    $intensity > 0 => 'bg-emerald-300',
                    default => 'bg-gray-100 dark:bg-gray-700'
                },
                'textColor' => $intensity > 0 ? 'text-white' : 'text-gray-900 dark:text-white'
            ];
        });

        return view('dashboard', [
            'totalHoursThisMonth' => $totalHoursThisMonth,
            'totalEarningsThisMonth' => $totalEarningsThisMonth,
            'averageHoursPerDay' => $averageHoursPerDay,
            'mostUsedService' => $mostUsedService,
            'recentTimeLogs' => $recentTimeLogs,
            'currentMonth' => Carbon::now()->format('F Y'),
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'hoursCalendar' => $hoursCalendar,
            'earningsCalendar' => $earningsCalendar,
            'firstDayOfWeek' => $startOfMonth->dayOfWeek,
            'weekDays' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
        ]);
    }
} 