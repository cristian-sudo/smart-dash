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
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;

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
    public $previewId = null;
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
    public $currentTimeLogs = [];
    public $timeLogsToRemove = [];
    public $showSendModal = false;
    public $recipientEmail = '';
    public $defaultEmailMessage = '';

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
        $this->availableTimeLogs = TimeLog::where('invoice_id', null)
            ->orWhere('invoice_id', $this->invoiceId)
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
        $this->currentTimeLogs = collect([]);
        $this->loadAvailableTimeLogs();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->invoiceId = $id;
        $invoice = Invoice::find($id);
        
        $this->client_id = $invoice->client_id;
        $this->company_id = $invoice->company_id;
        $this->date = $invoice->date->format('Y-m-d');
        $this->due_date = $invoice->due_date->format('Y-m-d');
        $this->status = $invoice->status;
        $this->notes = $invoice->notes;
        
        // Load current time logs
        $this->currentTimeLogs = $invoice->timeLogs;
        $this->selectedTimeLogs = $invoice->timeLogs->pluck('id')->toArray();
        
        $this->loadAvailableTimeLogs();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function removeTimeLog($timeLogId)
    {
        $this->timeLogsToRemove[] = $timeLogId;
        $this->selectedTimeLogs = array_filter($this->selectedTimeLogs, function($id) use ($timeLogId) {
            return $id != $timeLogId;
        });
    }

    public function save()
    {
        $this->validate([
            'client_id' => 'required',
            'company_id' => 'required',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'status' => 'required',
            'selectedTimeLogs' => 'required|array|min:1',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'client_id' => $this->client_id,
            'company_id' => $this->company_id,
            'date' => $this->date,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        // Calculate total hours and total amount
        $timeLogs = TimeLog::whereIn('id', $this->selectedTimeLogs)->with('service')->get();
        $totalHours = $timeLogs->sum('hours');
        $totalAmount = $timeLogs->sum(function ($log) {
            return $log->service->calculatePriceForHours($log->hours);
        });

        $data['total_hours'] = $totalHours;
        $data['total'] = $totalAmount;

        $isEditing = $this->invoiceId !== null;

        if ($isEditing) {
            $invoice = Invoice::find($this->invoiceId);
            $invoice->update($data);
            
            // First, remove all time logs from this invoice
            TimeLog::where('invoice_id', $invoice->id)->update(['invoice_id' => null]);
            
            // Then, add the newly selected time logs
            TimeLog::whereIn('id', $this->selectedTimeLogs)->update(['invoice_id' => $invoice->id]);
        } else {
            $invoice = Invoice::create($data);
            TimeLog::whereIn('id', $this->selectedTimeLogs)->update(['invoice_id' => $invoice->id]);
        }

        $this->reset(['showModal', 'invoiceId', 'client_id', 'company_id', 'date', 'due_date', 'status', 'notes', 'selectedTimeLogs', 'timeLogsToRemove']);
        $this->loadAvailableTimeLogs();
        $this->showNotification('Invoice ' . ($isEditing ? 'updated' : 'created') . ' successfully!');
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

    public function openSendModal($id)
    {
        $this->invoiceId = $id;
        $invoice = Invoice::find($id);
        $this->recipientEmail = $invoice->client->email;
        
        $this->defaultEmailMessage = "Dear {$invoice->client->name},\n\n";
        $this->defaultEmailMessage .= "Invoice Number: #{$invoice->invoice_number}\n";
        $this->defaultEmailMessage .= "Date: " . $invoice->date->format('M d, Y') . "\n";
        $this->defaultEmailMessage .= "Due Date: " . $invoice->due_date->format('M d, Y') . "\n";
        $this->defaultEmailMessage .= "Total Amount: $" . number_format($invoice->total, 2) . "\n\n";
        $this->defaultEmailMessage .= "Best regards,\n";
        $this->defaultEmailMessage .= auth()->user()->name;
        
        $this->showSendModal = true;
    }

    public function closeSendModal()
    {
        $this->showSendModal = false;
        $this->reset(['recipientEmail', 'defaultEmailMessage']);
    }

    public function sendInvoice()
    {
        $invoice = Invoice::find($this->invoiceId);
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

        try {
            Mail::to($invoice->client->email)
                ->send(new InvoiceEmail($invoice, $pdf->output(), $this->defaultEmailMessage));

            $invoice->update(['status' => 'sent']);
            $this->closeSendModal();
            $this->showNotification('Invoice sent successfully!');
        } catch (\Exception $e) {
            $this->showNotification('Failed to send invoice. Please try again.', 'error');
        }
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
