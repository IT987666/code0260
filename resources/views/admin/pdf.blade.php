<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color:   #20bec6;;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
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
