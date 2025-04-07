<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'desc');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';

        $invoices = Invoice::where('user_id', Auth::id())
            ->orderBy('created_at', $sort)
            ->get();

        return view('dashboard.invoices', compact('invoices', 'sort'));
    }

    public function create()
    {
        return view('dashboard.create-invoice');
    }

    public function preview(Request $request)
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

        // Create or update invoice
        $invoice = Invoice::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ],
            [
                'name' => "Invoice " . now()->format('Y-m-d'),
                'total_hours' => $totalHours,
                'total_amount' => $totalAmount,
            ]
        );

        $invoice->timeLogs()->sync($timeLogs->pluck('id'));

        return redirect()->route('invoices.index', ['preview' => $invoice->id])->with('success', 'Invoice created successfully.');
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function download(Request $request)
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

        $pdf = PDF::loadView('dashboard.invoice-pdf', [
            'timeLogs' => $timeLogs,
            'totalHours' => $totalHours,
            'totalAmount' => $totalAmount,
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date'],
        ]);

        // Configure PDF options
        $pdf->setPaper('A4');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('dpi', 300);
        $pdf->setOption('defaultFont', 'sans-serif');
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-left', 0);

        return $pdf->download('invoice.pdf');
    }
} 