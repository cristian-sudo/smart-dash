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
            padding: 2rem;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4rem;
        }
        .header-left {
            flex: 1;
        }
        .logo {
            max-height: 500px;
            min-height: 400px;
            width: auto;
            margin-bottom: 3rem;
            object-fit: contain;
        }
        .title {
            font-size: 80px;
            font-weight: bold;
            color: #111827;
            margin: 0;
            margin-bottom: 1rem;
        }
        .company-name {
            font-size: 44px;
            color: #4B5563;
            margin: 0;
        }
        .info-grid {
            width: 100%;
            display: table;
            table-layout: fixed;
            margin-bottom: 4rem;
        }
        .info-section {
            display: table-cell;
            width: 33.333%;
            vertical-align: top;
            padding-right: 2rem;
        }
        .info-section:last-child {
            padding-right: 0;
        }
        .section-title {
            font-size: 44px;
            font-weight: 600;
            color: #111827;
            margin: 0;
            margin-bottom: 2rem;
        }
        .info-text {
            font-size: 36px;
            color: #4B5563;
            margin: 1rem 0;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 3rem 0;
        }
        th {
            background-color: #F9FAFB;
            padding: 1.5rem 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            font-size: 34px;
        }
        td {
            padding: 1.5rem 1rem;
            color: #4B5563;
            border-bottom: 1px solid #E5E7EB;
            font-size: 34px;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            font-size: 34px;
            color: #6B7280;
        }
        .footer p {
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        @if($invoice->company && $invoice->company->color)
            <div style="height: 24px; width: 100%; background-color: {{ $invoice->company->color }}; margin-bottom: 2rem;"></div>
        @endif
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                @if($invoice->company && $invoice->company->logo && Storage::disk('public')->exists($invoice->company->logo))
                    <img src="data:image/png;base64,{{ base64_encode(Storage::disk('public')->get($invoice->company->logo)) }}" alt="Company Logo" class="logo" style="max-width: 600px; min-width: 400px;">
                @endif
                <h1 class="title">Invoice</h1>
                <p class="company-name">{{ $invoice->company ? $invoice->company->name : config('app.name') }}</p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <!-- From Section -->
            <div class="info-section">
                <h2 class="section-title">From:</h2>
                @if($invoice->company)
                    <p class="info-text">{{ $invoice->company->name }}</p>
                    @if($invoice->company->email)
                        <p class="info-text">{{ $invoice->company->email }}</p>
                    @endif
                    @if($invoice->company->phone)
                        <p class="info-text">{{ $invoice->company->phone }}</p>
                    @endif
                    @if($invoice->company->address)
                        <p class="info-text">{{ $invoice->company->address }}</p>
                    @endif
                @else
                    <p class="info-text">{{ config('app.name') }}</p>
                @endif
            </div>

            <!-- To Section -->
            <div class="info-section">
                <h2 class="section-title">To:</h2>
                <p class="info-text">{{ $invoice->client->name }}</p>
                @if($invoice->client->email)
                    <p class="info-text">{{ $invoice->client->email }}</p>
                @endif
                @if($invoice->client->phone)
                    <p class="info-text">{{ $invoice->client->phone }}</p>
                @endif
                @if($invoice->client->address)
                    <p class="info-text">{{ $invoice->client->address }}</p>
                @endif
            </div>

            <!-- Invoice Details Section -->
            <div class="info-section">
                <h2 class="section-title">Invoice Details:</h2>
                <p class="info-text">Invoice #: {{ $invoice->invoice_number }}</p>
                <p class="info-text">Date: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                <p class="info-text">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Time Logs Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 15%">Date</th>
                    <th style="width: 30%">Service</th>
                    <th style="width: 10%">Hrs</th>
                    <th style="width: 25%">Location</th>
                    <th style="width: 20%" class="text-right">Price</th>
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
                    <td colspan="4" class="text-right" style="font-weight: 600;">Total Hours:</td>
                    <td class="text-right" style="font-weight: 600;">{{ $totalHours }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right" style="font-weight: 600;">Total Amount:</td>
                    <td class="text-right" style="font-weight: 600;">${{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice. No signature is required.</p>
        </div>
    </div>
</body>
</html> 