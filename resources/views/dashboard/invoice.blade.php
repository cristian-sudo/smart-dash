<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice</h1>
        <p>{{ config('app.name') }}</p>
    </div>

    <div class="company-info">
        <p><strong>From:</strong> {{ config('app.name') }}</p>
        <p><strong>To:</strong> {{ auth()->user()->name }}</p>
    </div>

    <div class="invoice-details">
        <p><strong>Invoice Period:</strong> {{ $startDate }} to {{ $endDate }}</p>
        <p><strong>Date Generated:</strong> {{ now()->format('Y-m-d') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Service</th>
                <th>Hours</th>
                <th>Location</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timeLogs as $log)
            <tr>
                <td>{{ $log->date->format('Y-m-d') }}</td>
                <td>{{ $log->service->name }}</td>
                <td>{{ $log->hours }}</td>
                <td>{{ $log->location }}</td>
                <td>${{ number_format($log->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Total Hours:</td>
                <td>{{ $totalHours }}</td>
            </tr>
            <tr>
                <td colspan="4" class="total">Total Amount:</td>
                <td>${{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated invoice. No signature is required.</p>
    </div>
</body>
</html> 