<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
        }
        .container {
            width: 98%;
            padding: 1rem;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }
        .header-left h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .header-left p {
            color: #4B5563;
            margin: 0;
        }
        .header-right p {
            color: #4B5563;
            margin: 0;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .text-gray {
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
        }
        th, td {
            padding: 0.75rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }
        th {
            background-color: #F9FAFB;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #6B7280;
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
        .mt-8 {
            margin-top: 2rem;
        }
        .pt-8 {
            padding-top: 2rem;
        }
        .border-t {
            border-top: 1px solid #E5E7EB;
        }
        .text-center {
            text-align: center;
        }
        .text-sm {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Invoice</h1>
                <p>{{ config('app.name') }}</p>
            </div>
            <div class="header-right">
                <p>Date Generated: {{ now()->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Company and Client Info -->
        <div class="grid">
            <div>
                <h2 class="section-title">From:</h2>
                <p class="text-gray">{{ config('app.name') }}</p>
            </div>
            <div>
                <h2 class="section-title">To:</h2>
                <p class="text-gray">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div style="margin-bottom: 2rem;">
            <h2 class="section-title">Invoice Period:</h2>
            <p class="text-gray">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
        </div>

        <!-- Time Logs Table -->
        <div style="margin-bottom: 2rem;">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Hours</th>
                        <th>Location</th>
                        <th class="text-right">Price</th>
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
        <div class="mt-8 pt-8 border-t">
            <p class="text-center text-gray">Thank you for your business!</p>
            <p class="text-center text-sm text-gray" style="margin-top: 0.5rem;">This is a computer-generated invoice. No signature is required.</p>
        </div>
    </div>
</body>
</html> 