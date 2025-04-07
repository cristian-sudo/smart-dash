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
        
        // Get total hours and earnings for the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $timeLogsThisMonth = TimeLog::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();
            
        $totalHoursThisMonth = $timeLogsThisMonth->sum('hours');
        $totalEarningsThisMonth = $timeLogsThisMonth->sum('price');
        
        // Get recent time logs
        $recentTimeLogs = TimeLog::where('user_id', $user->id)
            ->with('service')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard', compact(
            'totalHoursThisMonth',
            'totalEarningsThisMonth',
            'recentTimeLogs'
        ));
    }
} 