<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\TimeLog;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\WithNotifications;
use App\Models\Client;
use App\Models\Company;

class Invoices extends Component
{
    use WithNotifications;
    use WithPagination;

    public $sort = 'desc';
    public $showModal = false;
    public $editingId = null;
    public $name = '';
    public $selectedTimeLogs = [];
    public $message = '';
    public $show = false;
    public $previewId = null;
    public $notificationMessage = '';
    public $invoiceId = null;
    public $clients = [];
    public $client_id = '';
    public $companies = [];
    public $company_id = '';
    public $date = '';
    public $due_date = '';
    public $status = 'draft';
    public $notes = '';
    public $availableTimeLogs = [];
    public $showNotification = false;

    protected $listeners = ['refreshInvoices' => '$refresh'];

    public function mount()
    {
        $this->sort = request('sort', 'desc');
        $this->previewId = request('preview');
        $this->clients = \App\Models\Client::where('user_id', auth()->id())->get();
        $this->companies = \App\Models\Company::where('user_id', auth()->id())->get();
        $this->date = now()->format('Y-m-d');
        $this->due_date = now()->addDays(30)->format('Y-m-d');
        $this->loadAvailableTimeLogs();
    }

    public function loadAvailableTimeLogs()
    {
        $this->availableTimeLogs = TimeLog::where('user_id', auth()->id())
            ->whereNull('invoice_id')
            ->orderBy('date', 'desc')
            ->get();
    }

    public function toggleSort()
    {
        $this->sort = $this->sort === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['invoiceId', 'client_id', 'company_id', 'date', 'due_date', 'status', 'notes', 'selectedTimeLogs']);
        $this->loadAvailableTimeLogs();
        $this->dispatch('open-modal');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->invoiceId = $invoice->id;
        $this->client_id = $invoice->client_id;
        $this->company_id = $invoice->company_id;
        $this->date = $invoice->date->format('Y-m-d');
        $this->due_date = $invoice->due_date->format('Y-m-d');
        $this->status = $invoice->status;
        $this->notes = $invoice->notes;
        $this->selectedTimeLogs = $invoice->timeLogs->pluck('id')->toArray();
        $this->loadAvailableTimeLogs();
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'status' => 'required|in:draft,sent,paid,overdue',
            'selectedTimeLogs' => 'required|array|min:1',
            'selectedTimeLogs.*' => 'exists:time_logs,id',
        ]);

        $totalHours = TimeLog::whereIn('id', $this->selectedTimeLogs)->sum('hours');
        $totalAmount = $totalHours * 100; // Assuming $100 per hour

        if ($this->invoiceId) {
            $invoice = Invoice::findOrFail($this->invoiceId);
            
            // Remove invoice_id from previously associated time logs
            TimeLog::where('invoice_id', $invoice->id)->update(['invoice_id' => null]);
            
            $invoice->update([
                'client_id' => $this->client_id,
                'company_id' => $this->company_id,
                'date' => $this->date,
                'due_date' => $this->due_date,
                'status' => $this->status,
                'notes' => $this->notes,
                'total_hours' => $totalHours,
                'total' => $totalAmount,
            ]);
        } else {
            $invoice = Invoice::create([
                'user_id' => auth()->id(),
                'client_id' => $this->client_id,
                'company_id' => $this->company_id,
                'date' => $this->date,
                'due_date' => $this->due_date,
                'status' => $this->status,
                'notes' => $this->notes,
                'total_hours' => $totalHours,
                'total' => $totalAmount,
            ]);
        }

        // Update time logs with invoice_id
        TimeLog::whereIn('id', $this->selectedTimeLogs)->update(['invoice_id' => $invoice->id]);

        $this->reset(['invoiceId', 'client_id', 'company_id', 'date', 'due_date', 'status', 'notes', 'selectedTimeLogs']);
        $this->loadAvailableTimeLogs();
        $this->dispatch('close-modal');
        $this->showNotification('Invoice ' . ($this->invoiceId ? 'updated' : 'created') . ' successfully!');
    }

    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        // Remove invoice_id from associated time logs
        TimeLog::where('invoice_id', $invoice->id)->update(['invoice_id' => null]);
        
        $invoice->delete();
        $this->showNotification('Invoice deleted successfully!');
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        $timeLogs = $invoice->timeLogs()->with('service')->orderBy('date')->get();
        
        $pdf = PDF::loadView('dashboard.invoice-pdf', [
            'timeLogs' => $timeLogs,
            'totalHours' => $invoice->total_hours,
            'totalAmount' => $invoice->total,
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

    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(['status' => 'paid']);
        $this->showNotification('Invoice marked as paid successfully!');
    }

    public function showNotification($message)
    {
        $this->notificationMessage = $message;
        $this->showNotification = true;
    }

    public function render()
    {
        $invoices = Invoice::where('user_id', Auth::id())
            ->with(['timeLogs.service', 'client'])
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
            'clients' => Client::where('user_id', auth()->id())
                ->orderBy('name')
                ->get(),
            'companies' => Company::where('user_id', auth()->id())
                ->orderBy('name')
                ->get(),
        ]);
    }
}
