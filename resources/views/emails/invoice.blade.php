<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            overflow: hidden;
        }
        .header {
            background-color: {{ $invoice->company->color ?? '#3B82F6' }};
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .message {
            white-space: pre-line;
            margin-bottom: 30px;
            color: #374151;
            font-size: 16px;
        }
        .invoice-info {
            background-color: #f3f4f6;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 30px;
        }
        .invoice-info p {
            margin: 5px 0;
            color: #4b5563;
        }
        .footer {
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .notice {
            font-size: 11px;
            color: #6b7280;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($invoice->company && $invoice->company->logo && Storage::disk('public')->exists($invoice->company->logo))
                <img src="data:image/png;base64,{{ base64_encode(Storage::disk('public')->get($invoice->company->logo)) }}" alt="{{ $invoice->company->name }} Logo">
            @endif
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
        </div>
        
        <div class="content">
            <div class="message">
                {!! nl2br(e($emailMessage)) !!}
            </div>

            <div class="invoice-info">
                <p><strong>Invoice Number:</strong> #{{ $invoice->invoice_number }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($invoice->total, 2) }}</p>
            </div>

            @if($invoice->products->count() > 0)
                <h3 style="font-size: 18px; font-weight: 600; margin-top: 24px; margin-bottom: 8px;">Products</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <th style="text-align: left; padding: 8px 0;">Product</th>
                            <th style="text-align: left; padding: 8px 0;">Quantity</th>
                            <th style="text-align: left; padding: 8px 0;">Price</th>
                            <th style="text-align: left; padding: 8px 0;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->products as $product)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 8px 0;">{{ $product->name }}</td>
                                <td style="padding: 8px 0;">{{ $product->pivot->quantity }}</td>
                                <td style="padding: 8px 0;">${{ number_format($product->pivot->price, 2) }}</td>
                                <td style="padding: 8px 0;">${{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="notice">
                <p>This is an automated message from {{ config('app.name') }}. Please do not reply to this email.</p>
                <p>If you have any questions about this invoice, please contact {{ $invoice->company->name ?? config('app.name') }} directly.</p>
                <p>This email and any attachments are confidential and intended solely for the use of the individual to whom they are addressed. If you have received this email in error, please notify the sender immediately and delete it from your system.</p>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ $invoice->company->name ?? config('app.name') }}. All rights reserved.</p>
            <p>This email was sent automatically by {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html> 