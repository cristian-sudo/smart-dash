<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\TimeLog;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class Invoices extends Component
{
    use WithPagination;

    public $sort = 'desc';
    public $showModal = false;
    public $editingId = null;
    public $name = '';
    public $selectedTimeLogs = [];
    public $message = '';
    public $show = false;
    public $previewId = null;

    public function mount()
    {
        $this->sort = request('sort', 'desc');
        $this->previewId = request('preview');
    }

    public function toggleSort()
    {
        $this->sort = $this->sort === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $this->editingId = $id;
        $this->name = $invoice->name;
        $this->selectedTimeLogs = $invoice->timeLogs->pluck('id')->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'selectedTimeLogs' => 'required|array|min:1',
            'selectedTimeLogs.*' => 'exists:time_logs,id',
        ]);

        $timeLogs = TimeLog::whereIn('id', $this->selectedTimeLogs)
            ->where('user_id', Auth::id())
            ->with('service')
            ->orderBy('date')
            ->get();

        if ($timeLogs->isEmpty()) {
            $this->message = 'No time logs selected.';
            $this->show = true;
            return;
        }

        $totalHours = $timeLogs->sum('hours');
        $totalAmount = $timeLogs->sum(function($log) {
            return $log->rate * $log->hours;
        });

        if ($this->editingId) {
            $invoice = Invoice::find($this->editingId);
            $invoice->update([
                'name' => $this->name,
                'total_hours' => $totalHours,
                'total_amount' => $totalAmount,
            ]);
            $invoice->timeLogs()->sync($timeLogs->pluck('id'));
            $this->message = 'Invoice updated successfully!';
        } else {
            $invoice = Invoice::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'total_hours' => $totalHours,
                'total_amount' => $totalAmount,
            ]);
            $invoice->timeLogs()->sync($timeLogs->pluck('id'));
            $this->message = 'Invoice created successfully!';
        }

        $this->show = true;
        $this->reset(['showModal', 'editingId', 'name', 'selectedTimeLogs']);
    }

    public function delete($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        $this->message = 'Invoice deleted successfully!';
        $this->show = true;
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        $timeLogs = $invoice->timeLogs()->with('service')->orderBy('date')->get();
        
        $pdf = PDF::loadView('dashboard.invoice-pdf', [
            'timeLogs' => $timeLogs,
            'totalHours' => $invoice->total_hours,
            'totalAmount' => $invoice->total_amount,
            'startDate' => $timeLogs->first()->date,
            'endDate' => $timeLogs->last()->date,
            'invoice' => $invoice
        ]);

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

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'invoice.pdf');
    }

    public function togglePreview($id)
    {
        $this->previewId = $this->previewId === $id ? null : $id;
    }

    public function render()
    {
        $invoices = Invoice::where('user_id', Auth::id())
            ->with(['timeLogs.service'])
            ->orderBy('created_at', $this->sort)
            ->paginate(10);

        $availableTimeLogs = TimeLog::where('user_id', Auth::id())
            ->whereDoesntHave('invoices')
            ->with('service')
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.invoices', [
            'invoices' => $invoices,
            'availableTimeLogs' => $availableTimeLogs,
        ]);
    }
}
