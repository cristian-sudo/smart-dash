<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TimeLogController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'desc');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';

        $timeLogs = TimeLog::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('date', $sort)
            ->get();

        $services = Service::all();

        return view('dashboard.time-logs', compact('timeLogs', 'services', 'sort'));
    }

    public function show(TimeLog $timeLog)
    {
        if ($timeLog->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json($timeLog);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0.25|max:24',
            'location' => 'nullable|string|max:255',
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
        $totalAmount = $timeLogs->sum(function($log) {
            return $log->service->calculatePriceForHours($log->hours);
        });

        $pdf = PDF::loadView('dashboard.invoice', [
            'timeLogs' => $timeLogs,
            'totalHours' => $totalHours,
            'totalAmount' => $totalAmount,
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date'],
        ]);

        return $pdf->download('invoice.pdf');
    }

    public function previewInvoice(Request $request)
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
        $totalAmount = $timeLogs->sum(function($log) {
            return $log->service->calculatePriceForHours($log->hours);
        });

        return view('dashboard.invoice', [
            'timeLogs' => $timeLogs,
            'totalHours' => $totalHours,
            'totalAmount' => $totalAmount,
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date'],
        ]);
    }

    public function update(Request $request, TimeLog $timeLog)
    {
        if ($timeLog->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'hours' => 'required|numeric|min:0.25',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $timeLog->update($validated);

        return redirect()->route('time-logs.index')->with('success', 'Time log updated successfully.');
    }

    public function destroy(TimeLog $timeLog)
    {
        if ($timeLog->user_id !== Auth::id()) {
            abort(403);
        }

        $timeLog->delete();
        return redirect()->route('time-logs.index')->with('success', 'Time log deleted successfully.');
    }

    public function duplicate(TimeLog $timeLog)
    {
        $newTimeLog = $timeLog->replicate();
        $newTimeLog->date = now()->format('Y-m-d');
        $newTimeLog->save();

        return redirect()->route('time-logs.index')->with('success', 'Time log duplicated successfully.');
    }
} 