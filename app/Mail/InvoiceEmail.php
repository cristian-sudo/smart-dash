<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdf;
    public $emailMessage;

    public function __construct(Invoice $invoice, $pdf, $message)
    {
        $this->invoice = $invoice;
        $this->pdf = $pdf;
        $this->emailMessage = $message;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Invoice #' . $this->invoice->invoice_number,
            from: config('mail.from.address', 'invoices@yourdomain.com'),
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'invoice' => $this->invoice,
                'message' => $this->emailMessage,
            ],
        );
    }

    public function attachments()
    {
        return [
            Attachment::fromData(fn () => $this->pdf, 'invoice.pdf')
                ->withMime('application/pdf'),
        ];
    }
} 