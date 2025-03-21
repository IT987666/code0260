<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Report</title>
    <style>
   body {
    font-family: DejaVu Sans, sans-serif !important;
}

.table {
    width: 100% !important;
    border-collapse: collapse !important;
    margin-top: 20px !important;
}

.table, .table th, .table td {
    border: 1px solid black !important;
}

tr {
    page-break-inside: avoid !important;
}

.table th, .table td {
    padding: 8px !important;
    text-align: center !important;
}

.table th {
    background-color: #20bec6 !important;
}

.title {
    text-align: center !important;
    font-size: 20px !important;
    font-weight: bold !important;
    margin-top: 10px !important;
}

@media print {
    body {
        -webkit-print-color-adjust: exact !important;
    }
}


    </style>
</head>
<body>
    <div class="title">Orders Report</div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Total Items</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>{{ $order->orderItems->count() }}</td>
                    <td>{{ $order->note ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
