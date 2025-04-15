<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
        }
        .container {
            width: 100%;
            max-width: 190mm;
            margin: 0 auto;
            padding: 1rem;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }
        .header-left {
            flex: 1;
            padding-right: 1rem;
        }
        .header-right {
            flex: 1;
            text-align: right;
            padding-left: 1rem;
        }
        .header-left h1 {
            font-size: 80px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .header-left p {
            font-size: 48px;
            color: #4B5563;
            margin: 0;
        }
        .header-right p {
            font-size: 48px;
            color: #4B5563;
            margin: 0;
        }
        .from-to-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 2rem;
        }
        .from-to-section {
            flex: 1;
            padding: 0 0.25rem;
        }
        .from-to-section:first-child {
            padding-left: 0;
        }
        .from-to-section:last-child {
            padding-right: 0;
        }
        .section-title {
            font-size: 60px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .text-gray {
            font-size: 44px;
            color: #4B5563;
        }
        .text-white {
            color: #FFFFFF;
        }
        .bg-gray-50 {
            background-color: #F9FAFB;
        }
        .bg-gray-700 {
            background-color: #374151;
        }
        .divide-y {
            border-bottom: 1px solid #E5E7EB;
        }
        .divide-gray-200 {
            border-color: #E5E7EB;
        }
        .divide-gray-700 {
            border-color: #374151;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 44px;
        }
        th, td {
            padding: 0.5rem 1rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }
        th {
            background-color: #F9FAFB;
            font-weight: 600;
            text-transform: uppercase;
            color: #6B7280;
            white-space: nowrap;
        }
        td {
            color: #4B5563;
        }
        .text-right {
            text-align: right;
        }
        .font-semibold {
            font-weight: 600;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
        .pt-4 {
            padding-top: 1.5rem;
        }
        .border-t {
            border-top: 1px solid #E5E7EB;
        }
        .text-center {
            text-align: center;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .mb-1 {
            margin-bottom: 0.5rem;
        }
        .mt-1 {
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                @if($invoice->company && $invoice->company->logo && Storage::disk('public')->exists($invoice->company->logo))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $invoice->company->logo))) }}" alt="Company Logo" style="max-height: 300px; min-height: 250px; margin-bottom: 2rem; object-fit: contain;">
                @endif
                <h1>Invoice</h1>
                <p class="text-gray">{{ $invoice->company ? $invoice->company->name : config('app.name') }}</p>
            </div>
            <div class="header-right">
                <p class="text-gray">Date Generated: {{ now()->format('M d, Y') }}</p>
                <p class="text-gray">Invoice #: {{ $invoice->invoice_number }}</p>
                <p class="text-gray">Date: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                <p class="text-gray">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                <p class="text-gray">Status: {{ ucfirst($invoice->status) }}</p>
            </div>
        </div>

        <!-- Company, Client, and Invoice Info -->
        <div class="from-to-container">
            <div class="from-to-section">
                <h2 class="section-title">From:</h2>
                @if($invoice->company)
                    <p class="text-gray">{{ $invoice->company->name }}</p>
                    @if($invoice->company->email)
                        <p class="text-gray">{{ $invoice->company->email }}</p>
                    @endif
                    @if($invoice->company->phone)
                        <p class="text-gray">{{ $invoice->company->phone }}</p>
                    @endif
                    @if($invoice->company->address)
                        <p class="text-gray">{{ $invoice->company->address }}</p>
                    @endif
                    @if($invoice->company->tax_number)
                        <p class="text-gray">Tax Number: {{ $invoice->company->tax_number }}</p>
                    @endif
                    @if($invoice->company->registration_number)
                        <p class="text-gray">Reg Number: {{ $invoice->company->registration_number }}</p>
                    @endif
                @else
                    <p class="text-gray">{{ config('app.name') }}</p>
                @endif
            </div>
            <div class="from-to-section">
                <h2 class="section-title">To:</h2>
                <p class="text-gray">{{ $invoice->client->name }}</p>
                @if($invoice->client->email)
                    <p class="text-gray">{{ $invoice->client->email }}</p>
                @endif
                @if($invoice->client->phone)
                    <p class="text-gray">{{ $invoice->client->phone }}</p>
                @endif
                @if($invoice->client->address)
                    <p class="text-gray">{{ $invoice->client->address }}</p>
                @endif
            </div>
            <div class="from-to-section">
                <h2 class="section-title">Invoice Details:</h2>
                <p class="text-gray">Invoice #: {{ $invoice->invoice_number }}</p>
                <p class="text-gray">Date: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                <p class="text-gray">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                <p class="text-gray">Status: {{ ucfirst($invoice->status) }}</p>
            </div>
        </div>

        <!-- Time Logs Table -->
        <div class="mb-4">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20%">Date</th>
                        <th style="width: 25%">Service</th>
                        <th style="width: 5%">Hrs</th>
                        <th style="width: 10%">Location</th>
                        <th style="width: 40%" class="text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeLogs as $log)
                    <tr>
                        <td>{{ $log->date->format('M d, Y') }}</td>
                        <td>{{ $log->service->name }}</td>
                        <td>{{ $log->hours }}</td>
                        <td>{{ $log->location }}</td>
                        <td class="text-right">${{ number_format($log->service->calculatePriceForHours($log->hours), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-semibold">Total Hours:</td>
                        <td class="text-right font-semibold">{{ $totalHours }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right font-semibold">Total Amount:</td>
                        <td class="text-right font-semibold">${{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-4 pt-4 border-t">
            <p class="text-center text-gray">Thank you for your business!</p>
            <p class="text-center text-gray mt-1">This is a computer-generated invoice. No signature is required.</p>
        </div>
    </div>
</body>
</html> 