<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get time logs for the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $timeLogsThisMonth = TimeLog::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with('service')
            ->get();
            
        // Calculate total hours and earnings for the current month
        $totalHoursThisMonth = $timeLogsThisMonth->sum('hours');
        $totalEarningsThisMonth = $timeLogsThisMonth->sum(function($log) {
            return $log->service->calculatePriceForHours($log->hours);
        });

        // Calculate average hours per day
        $daysInMonth = Carbon::now()->daysInMonth;
        $averageHoursPerDay = $daysInMonth > 0 ? $totalHoursThisMonth / $daysInMonth : 0;

        // Find most used service
        $mostUsedService = 'No services used';
        if ($timeLogsThisMonth->isNotEmpty()) {
            $mostUsedService = $timeLogsThisMonth
                ->groupBy('service_id')
                ->map(function($logs) {
                    return [
                        'service' => $logs->first()->service->name,
                        'hours' => $logs->sum('hours')
                    ];
                })
                ->sortByDesc('hours')
                ->first()['service'];
        }

        // Get recent time logs
        $recentTimeLogs = TimeLog::where('user_id', $user->id)
            ->with('service')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard', compact(
            'totalHoursThisMonth',
            'totalEarningsThisMonth',
            'averageHoursPerDay',
            'mostUsedService',
            'recentTimeLogs'
        ));
    }
} 