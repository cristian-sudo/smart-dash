<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TimeLogController extends Controller
{
    public function index()
    {
        $timeLogs = TimeLog::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('date', 'desc')
            ->get();

        $services = Service::all();

        return view('dashboard.time-logs', compact('timeLogs', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0.5|max:24',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        TimeLog::create($validated);

        return redirect()->back()->with('success', 'Time log created successfully.');
    }

    public function generateInvoice(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $timeLogs = TimeLog::where('user_id', Auth::id())
            ->whereBetween('date', [$validated['start_date'], $validated['end_date']])
            ->with('service')
            ->orderBy('date')
            ->get();

        $totalHours = $timeLogs->sum('hours');
        $totalAmount = $timeLogs->sum('price');

        $pdf = PDF::loadView('dashboard.invoice', [
            'timeLogs' => $timeLogs,
            'totalHours' => $totalHours,
            'totalAmount' => $totalAmount,
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date'],
        ]);

        return $pdf->download('invoice.pdf');
    }
} 